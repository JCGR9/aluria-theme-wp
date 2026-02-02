/* ============================================
   ALURIA MODAS - JavaScript Principal WordPress
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // SCROLL SUAVE PARA ENLACES INTERNOS
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ============================================
    // MENÚ MÓVIL
    // ============================================
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });
        
        // Cerrar menú al hacer clic en un enlace
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }
    
    // ============================================
    // DROPDOWN CATEGORÍAS DESKTOP
    // ============================================
    const dropdownItems = document.querySelectorAll('.nav-links .menu-item-has-children');
    
    dropdownItems.forEach(item => {
        const link = item.querySelector(':scope > a');
        
        if (link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Cerrar otros dropdowns abiertos
                dropdownItems.forEach(other => {
                    if (other !== item) {
                        other.classList.remove('open');
                    }
                });
                
                // Toggle del dropdown actual
                item.classList.toggle('open');
            });
        }
    });
    
    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.menu-item-has-children')) {
            dropdownItems.forEach(item => {
                item.classList.remove('open');
            });
        }
    });
    
    // ============================================
    // HEADER SCROLL
    // ============================================
    const header = document.querySelector('.header');
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        } else {
            header.style.boxShadow = 'none';
        }
        
        lastScroll = currentScroll;
    });
    
    // ============================================
    // NEWSLETTER FORM
    // ============================================
    const newsletterForm = document.getElementById('newsletterForm');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            alert('¡Gracias por suscribirte! Te mantendremos informada de nuestras novedades.');
            this.reset();
        });
    }
    
    // ============================================
    // CARRITO - WooCommerce Integration
    // ============================================
    const cart = {
        updateUI: function(count) {
            const countElements = document.querySelectorAll('.cart-count');
            countElements.forEach(el => {
                if (typeof count !== 'undefined') {
                    el.textContent = count;
                }
                const currentCount = parseInt(el.textContent) || 0;
                el.style.display = currentCount > 0 ? 'flex' : 'none';
            });
        },
        // Obtener el conteo real del carrito via AJAX
        fetchCount: function() {
            if (typeof aluria_ajax !== 'undefined') {
                fetch(aluria_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=aluria_get_cart_count'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.count !== undefined) {
                        this.updateUI(data.count);
                    }
                })
                .catch(err => console.log('Cart count error:', err));
            }
        }
    };
    
    // Actualizar contador al cargar la página
    cart.fetchCount();
    window.aluriCart = cart;
    
    // ============================================
    // ANIMACIONES AL SCROLL
    // ============================================
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            .animate-element {
                opacity: 0;
                transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .animate-element.animate-in {
                opacity: 1 !important;
                transform: translate(0, 0) scale(1) !important;
            }
            
            .animate-fade-up {
                transform: translateY(60px);
            }
            
            .animate-fade-left {
                transform: translateX(-60px);
            }
            
            .animate-fade-right {
                transform: translateX(60px);
            }
            
            .animate-zoom {
                transform: scale(0.8);
            }
            
            .animate-fade-rotate {
                transform: translateY(40px) rotate(-3deg);
            }
            
            .section-title {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .section-title.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
            
            .hero-content {
                animation: heroFadeIn 1.2s ease-out forwards;
            }
            
            @keyframes heroFadeIn {
                0% { opacity: 0; transform: translateY(40px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            
            .hero-image {
                animation: heroImageIn 1.4s ease-out 0.3s forwards;
                opacity: 0;
            }
            
            @keyframes heroImageIn {
                0% { opacity: 0; transform: scale(0.95); }
                100% { opacity: 1; transform: scale(1); }
            }
            
            .footer-col {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s ease;
            }
            
            .footer-col.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
            
            .newsletter {
                opacity: 0;
                transform: translateY(40px);
                transition: all 0.8s ease;
            }
            
            .newsletter.animate-in {
                opacity: 1;
                transform: translateY(0);
            }
            
            .product-card img,
            .category-card img {
                transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .product-card:hover img,
            .category-card:hover img {
                transform: scale(1.08);
            }
            
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .animate-spin {
                animation: spin 1s linear infinite;
            }
        </style>
    `);
    
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -80px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.delay || 0;
                setTimeout(() => {
                    entry.target.classList.add('animate-in');
                }, delay);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.category-card').forEach((el, index) => {
        el.classList.add('animate-element', 'animate-fade-up');
        el.dataset.delay = index * 150;
        observer.observe(el);
    });
    
    document.querySelectorAll('.product-card').forEach((el, index) => {
        const animations = ['animate-fade-up', 'animate-zoom', 'animate-fade-rotate'];
        const randomAnim = animations[index % 3];
        el.classList.add('animate-element', randomAnim);
        el.dataset.delay = (index % 4) * 100;
        observer.observe(el);
    });
    
    document.querySelectorAll('.feature').forEach((el, index) => {
        el.classList.add('animate-element', 'animate-fade-up');
        el.dataset.delay = index * 200;
        observer.observe(el);
    });
    
    document.querySelectorAll('.section-title').forEach(el => observer.observe(el));
    document.querySelectorAll('.footer-col').forEach((el, index) => {
        el.dataset.delay = index * 150;
        observer.observe(el);
    });
    document.querySelectorAll('.newsletter').forEach(el => observer.observe(el));
    document.querySelectorAll('.contact-card, .contact-info-item').forEach((el, index) => {
        el.classList.add('animate-element', 'animate-fade-up');
        el.dataset.delay = index * 100;
        observer.observe(el);
    });
    
    // ============================================
    // LAZY LOADING DE IMÁGENES
    // ============================================
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    lazyImages.forEach(img => imageObserver.observe(img));
    
    // ============================================
    // SMOOTH SCROLL PARA ANCLAS
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // ============================================
    // BUSCADOR - WooCommerce AJAX
    // ============================================
    const searchToggle = document.getElementById('searchToggle');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchClose = document.getElementById('searchClose');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    if (searchToggle && searchOverlay) {
        // Abrir buscador
        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            searchOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => searchInput && searchInput.focus(), 100);
        });
        
        // Cerrar buscador
        if (searchClose) {
            searchClose.addEventListener('click', function() {
                closeSearch();
            });
        }
        
        // Cerrar al hacer clic en overlay
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay || e.target.classList.contains('search-container')) {
                // Solo cerrar si se hace clic fuera de los elementos del buscador
            }
        });
        
        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                closeSearch();
            }
        });
        
        function closeSearch() {
            searchOverlay.classList.remove('active');
            document.body.style.overflow = '';
            if (searchInput) searchInput.value = '';
            if (searchResults) searchResults.innerHTML = '';
        }
        
        // Búsqueda en tiempo real con AJAX
        let searchTimeout;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length < 2) {
                    searchResults.innerHTML = '';
                    return;
                }
                
                searchResults.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">Buscando...</p>';
                
                searchTimeout = setTimeout(() => {
                    if (typeof aluria_ajax !== 'undefined') {
                        fetch(aluria_ajax.ajax_url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'action=aluria_product_search&query=' + encodeURIComponent(query)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.results && data.results.length > 0) {
                                searchResults.innerHTML = data.results.map(p => `
                                    <a href="${p.url}" class="search-result-item">
                                        <img src="${p.image || ''}" alt="${p.name}">
                                        <div class="search-result-info">
                                            <h4>${p.name}</h4>
                                            <span>${p.price}</span>
                                        </div>
                                    </a>
                                `).join('');
                            } else {
                                searchResults.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">No se encontraron resultados</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error en búsqueda:', error);
                            searchResults.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">Error en la búsqueda</p>';
                        });
                    } else {
                        searchResults.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">Presiona Enter para buscar</p>';
                    }
                }, 300);
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const form = this.closest('form');
                    if (form) form.submit();
                }
            });
        }
    }
    
    // ============================================
    // SISTEMA DE FAVORITOS - DESACTIVADO
    // ============================================
    // Sistema de favoritos comentado - ya no se usa en el diseño actual
    /*
    const favorites = {
        items: JSON.parse(localStorage.getItem('aluriaFavorites')) || [],
        
        toggle: function(productId) {
            const index = this.items.indexOf(productId);
            if (index === -1) {
                this.items.push(productId);
            } else {
                this.items.splice(index, 1);
            }
            this.save();
            this.updateUI();
            return index === -1;
        },
        
        isFavorite: function(productId) {
            return this.items.includes(productId);
        },
        
        getCount: function() {
            return this.items.length;
        },
        
        save: function() {
            localStorage.setItem('aluriaFavorites', JSON.stringify(this.items));
        },
        
        updateUI: function() {
            const countEl = document.querySelector('.favorites-count');
            if (countEl) {
                const count = this.getCount();
                countEl.textContent = count;
                countEl.style.display = count > 0 ? 'flex' : 'none';
            }
            
            document.querySelectorAll('.add-favorite, .favorite-btn').forEach(btn => {
                const productId = btn.dataset.productId || (btn.closest('.product-card') ? btn.closest('.product-card').dataset.productId : null);
                if (productId && this.isFavorite(productId)) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }
    };
    
    // Manejar clics en botones de favoritos
    document.addEventListener('click', function(e) {
        const favBtn = e.target.closest('.add-favorite, .favorite-btn');
        if (favBtn) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = favBtn.dataset.productId || (favBtn.closest('.product-card') ? favBtn.closest('.product-card').dataset.productId : null);
            if (productId) {
                const added = favorites.toggle(productId);
                favBtn.classList.toggle('active', added);
                
                favBtn.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    favBtn.style.transform = '';
                }, 200);
            }
        }
    });
    
    favorites.updateUI();
    window.aluriaFavorites = favorites;
    */
    
    // ============================================
    // MODAL VISTA RÁPIDA - DESACTIVADO
    // ============================================
    // El modal Quick View ya no se usa (los botones fueron eliminados)
    // Los usuarios acceden al producto haciendo clic directamente en la imagen

    // ============================================
    // PRODUCT PAGE - Gallery Thumbnails
    // ============================================
    document.querySelectorAll('.gallery-thumbnails .thumb').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const newImage = this.dataset.image;
            const mainImage = document.getElementById('mainProductImage');
            
            if (mainImage && newImage) {
                mainImage.src = newImage;
                document.querySelectorAll('.gallery-thumbnails .thumb').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
    
    // ============================================
    // PRODUCT PAGE - Tabs
    // ============================================
    document.querySelectorAll('.tabs-nav .tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            document.querySelectorAll('.tabs-nav .tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            const targetPanel = document.getElementById(tabId);
            if (targetPanel) targetPanel.classList.add('active');
        });
    });
    
    // ============================================
    // PRODUCT PAGE - Zoom on single product
    // ============================================
    const mainProductImage = document.getElementById('mainProductImage');
    const productZoomLens = document.getElementById('productZoomLens');
    const productZoomResult = document.getElementById('productZoomResult');
    
    if (mainProductImage && productZoomLens && productZoomResult) {
        const container = mainProductImage.parentElement;
        const zoomLevel = 2.5;
        
        container.addEventListener('mouseenter', function() {
            productZoomLens.style.display = 'block';
            productZoomResult.style.display = 'block';
            productZoomResult.style.backgroundImage = `url('${mainProductImage.src}')`;
        });
        
        container.addEventListener('mouseleave', function() {
            productZoomLens.style.display = 'none';
            productZoomResult.style.display = 'none';
        });
        
        container.addEventListener('mousemove', function(e) {
            const rect = container.getBoundingClientRect();
            let x = e.clientX - rect.left;
            let y = e.clientY - rect.top;
            
            const lensSize = 80;
            let lensX = x - lensSize / 2;
            let lensY = y - lensSize / 2;
            
            lensX = Math.max(0, Math.min(lensX, rect.width - lensSize));
            lensY = Math.max(0, Math.min(lensY, rect.height - lensSize));
            
            productZoomLens.style.left = lensX + 'px';
            productZoomLens.style.top = lensY + 'px';
            
            const zoomResultSize = 250;
            let resultX = rect.right + 20;
            let resultY = e.clientY - zoomResultSize / 2;
            
            if (resultX + zoomResultSize > window.innerWidth) {
                resultX = rect.left - zoomResultSize - 20;
            }
            
            resultY = Math.max(20, Math.min(resultY, window.innerHeight - zoomResultSize - 20));
            
            productZoomResult.style.left = resultX + 'px';
            productZoomResult.style.top = resultY + 'px';
            
            const lensCenterX = lensX + lensSize / 2;
            const lensCenterY = lensY + lensSize / 2;
            
            const bgWidth = rect.width * zoomLevel;
            const bgHeight = rect.height * zoomLevel;
            
            const bgX = (lensCenterX / rect.width) * bgWidth - zoomResultSize / 2;
            const bgY = (lensCenterY / rect.height) * bgHeight - zoomResultSize / 2;
            
            productZoomResult.style.backgroundSize = `${bgWidth}px ${bgHeight}px`;
            productZoomResult.style.backgroundPosition = `-${bgX}px -${bgY}px`;
        });
    }
    
});
