/* ============================================
   ALURIA MODAS - JavaScript Principal WordPress
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
    
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
        updateUI: function() {
            const countElements = document.querySelectorAll('.cart-count');
            countElements.forEach(el => {
                const count = parseInt(el.textContent) || 0;
                el.style.display = count > 0 ? 'flex' : 'none';
            });
        }
    };
    
    cart.updateUI();
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
    // SISTEMA DE FAVORITOS
    // ============================================
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
    
    // ============================================
    // MODAL VISTA RÁPIDA (QUICK VIEW)
    // ============================================
    
    // El modal ya existe en footer.php (PHP), no crearlo dinámicamente
        // Cantidad +/-
        document.addEventListener('click', function(e) {
            if (e.target.id === 'qtyMinus') {
                e.preventDefault();
                const qtyEl = document.getElementById('qtyValue');
                let val = parseInt(qtyEl.textContent);
                if (val > 1) qtyEl.textContent = val - 1;
            }
            if (e.target.id === 'qtyPlus') {
                e.preventDefault();
                const qtyEl = document.getElementById('qtyValue');
                let val = parseInt(qtyEl.textContent);
                if (val < 10) qtyEl.textContent = val + 1;
            }
        });
        
        // Función de lupa/zoom
        function initZoom() {
            const modalImageContainer = document.querySelector('#quickViewModal .quick-view-image');
            const modalImage = document.getElementById('quickViewImage');
            const zoomLens = document.getElementById('zoomLens');
            const zoomResult = document.getElementById('zoomResult');
            
            if (!modalImage || !zoomLens || !zoomResult || !modalImageContainer) return;
            
            const zoomLevel = 2.5;
            
            modalImageContainer.onmouseenter = function() {
                zoomLens.style.display = 'block';
                zoomResult.style.display = 'block';
                zoomResult.style.backgroundImage = `url('${modalImage.src}')`;
            };
            
            modalImageContainer.onmouseleave = function() {
                zoomLens.style.display = 'none';
                zoomResult.style.display = 'none';
            };
            
            modalImageContainer.onmousemove = function(e) {
                const rect = modalImageContainer.getBoundingClientRect();
                let x = e.clientX - rect.left;
                let y = e.clientY - rect.top;
                
                const lensSize = 80;
                let lensX = x - lensSize / 2;
                let lensY = y - lensSize / 2;
                
                lensX = Math.max(0, Math.min(lensX, rect.width - lensSize));
                lensY = Math.max(0, Math.min(lensY, rect.height - lensSize));
                
                zoomLens.style.left = lensX + 'px';
                zoomLens.style.top = lensY + 'px';
                
                const zoomResultSize = 250;
                let resultX = rect.right + 20;
                let resultY = e.clientY - zoomResultSize / 2;
                
                if (resultX + zoomResultSize > window.innerWidth) {
                    resultX = rect.left - zoomResultSize - 20;
                }
                
                resultY = Math.max(20, Math.min(resultY, window.innerHeight - zoomResultSize - 20));
                
                zoomResult.style.left = resultX + 'px';
                zoomResult.style.top = resultY + 'px';
                
                const lensCenterX = lensX + lensSize / 2;
                const lensCenterY = lensY + lensSize / 2;
                
                const bgWidth = rect.width * zoomLevel;
                const bgHeight = rect.height * zoomLevel;
                
                const bgX = (lensCenterX / rect.width) * bgWidth - zoomResultSize / 2;
                const bgY = (lensCenterY / rect.height) * bgHeight - zoomResultSize / 2;
                
                zoomResult.style.backgroundSize = `${bgWidth}px ${bgHeight}px`;
                zoomResult.style.backgroundPosition = `-${bgX}px -${bgY}px`;
            };
        }
        
        // Abrir modal con AJAX de WooCommerce
        document.addEventListener('click', function(e) {
            const quickViewBtn = e.target.closest('.quick-view');
            if (quickViewBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                const productId = quickViewBtn.dataset.productId;
                if (!productId) return;
                
                currentProductId = productId;
                
                quickViewModal.classList.add('active');
                document.body.style.overflow = 'hidden';
                
                // Loading state
                const img = document.getElementById('quickViewImage');
                if (img) img.src = '';
                
                if (typeof aluria_ajax !== 'undefined') {
                    fetch(aluria_ajax.ajax_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=aluria_quick_view&product_id=' + productId + '&nonce=' + aluria_ajax.nonce
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.success && response.data) {
                            const data = response.data;
                            
                            const imgEl = document.getElementById('quickViewImage');
                            if (imgEl) {
                                imgEl.src = data.image || '';
                                imgEl.alt = data.name || '';
                            }
                            
                            const title = document.getElementById('quickViewTitle');
                            if (title) title.textContent = data.name || '';
                            
                            const price = document.getElementById('quickViewPrice');
                            if (price) price.innerHTML = data.price || '';
                            
                            const category = document.getElementById('quickViewCategory');
                            if (category) category.textContent = data.category || '';
                            
                            const description = document.getElementById('quickViewDescription');
                            if (description) description.innerHTML = data.short_description || '';
                            
                            const stock = document.getElementById('quickViewStock');
                            if (stock) {
                                stock.textContent = data.stock_text || '';
                                stock.className = 'quick-view-stock ' + (data.stock_class || 'in-stock');
                            }
                            
                            const link = document.getElementById('quickViewLink');
                            if (link) link.href = data.permalink || '#';
                            
                            // WhatsApp
                            const wa = document.getElementById('quickViewWhatsApp');
                            if (wa) {
                                const priceText = data.price ? data.price.replace(/<[^>]*>/g, '') : '';
                                const whatsappMsg = encodeURIComponent(`Hola! Me interesa "${data.name}" (${priceText}). ¿Está disponible?`);
                                wa.href = `https://wa.me/34620932637?text=${whatsappMsg}`;
                            }
                            
                            // Favoritos
                            const favBtn = document.getElementById('quickViewFavorite');
                            if (favBtn) {
                                if (favorites.isFavorite(productId)) {
                                    favBtn.classList.add('active');
                                    favBtn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> En favoritos`;
                                } else {
                                    favBtn.classList.remove('active');
                                    favBtn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> Añadir a favoritos`;
                                }
                            }
                            
                            // Resetear cantidad
                            const qtyValue = document.getElementById('qtyValue');
                            if (qtyValue) qtyValue.textContent = '1';
                            
                            // Inicializar zoom
                            const imageEl = document.getElementById('quickViewImage');
                            if (imageEl) {
                                imageEl.onload = initZoom;
                                if (imageEl.complete && imageEl.src) initZoom();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error cargando producto:', error);
                    });
                }
            }
        });
        
        // Cerrar modal
        function closeQuickView() {
            quickViewModal.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        if (modalClose) modalClose.addEventListener('click', closeQuickView);
        if (modalOverlay) modalOverlay.addEventListener('click', closeQuickView);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && quickViewModal.classList.contains('active')) {
                closeQuickView();
            }
        });
        
        // Toggle favorito desde modal
        document.addEventListener('click', function(e) {
            if (e.target.id === 'quickViewFavorite' || e.target.closest('#quickViewFavorite')) {
                const favBtn = document.getElementById('quickViewFavorite');
                if (currentProductId && favBtn) {
                    const added = favorites.toggle(currentProductId);
                    favBtn.classList.toggle('active', added);
                    favBtn.innerHTML = added ? 
                        `<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> En favoritos` :
                        `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg> Añadir a favoritos`;
                }
            }
        });
        
        // Añadir al carrito via AJAX
        document.addEventListener('click', function(e) {
            if (e.target.id === 'addToCartModal' || e.target.closest('#addToCartModal')) {
                e.preventDefault();
                
                if (!currentProductId || typeof aluria_ajax === 'undefined') return;
                
                const qtyEl = document.getElementById('qtyValue');
                const quantity = qtyEl ? parseInt(qtyEl.textContent) : 1;
                const btn = document.getElementById('addToCartModal');
                
                btn.disabled = true;
                btn.innerHTML = '<svg width="18" height="18" class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle></svg> Añadiendo...';
                
                fetch(aluria_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=woocommerce_ajax_add_to_cart&product_id=' + currentProductId + '&quantity=' + quantity
                })
                .then(response => response.json())
                .then(data => {
                    if (data.cart_count !== undefined) {
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = data.cart_count;
                            el.style.display = data.cart_count > 0 ? 'flex' : 'none';
                        });
                    }
                    
                    btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg> ¡Añadido!';
                    btn.style.background = 'var(--color-primary)';
                    
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg> Añadir al Carrito';
                        btn.style.background = '';
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error añadiendo al carrito:', error);
                    btn.disabled = false;
                    btn.innerHTML = 'Error - Reintentar';
                });
            }
        });
    }
    
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
