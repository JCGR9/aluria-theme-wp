<?php
/**
 * Front Page Template
 *
 * @package Aluria
 */

get_header();
?>

    <!-- Hero Section - Imagen a ancho completo -->
    <section class="hero hero-fullwidth">
        <div class="hero-background">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/header.jpeg" alt="Aluria Modas">
        </div>
        <div class="hero-overlay">
            <?php 
            $shop_url = class_exists('WooCommerce') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop/');
            $hero_link = get_theme_mod('hero_button_link', $shop_url);
            ?>
            <a href="<?php echo esc_url($hero_link); ?>" class="btn btn-primary btn-hero">
                <?php echo esc_html(get_theme_mod('hero_button_text', 'Ver catálogo')); ?>
            </a>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="featured">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Lo más nuevo', 'aluria'); ?></h2>
            <div class="products-grid">
                <?php
                // Query mejorada para asegurar que encuentra productos
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 12,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'exclude-from-catalog',
                            'operator' => 'NOT IN',
                        ),
                    ),
                );
                
                $featured_products = new WP_Query($args);
                
                // DEBUG: Descomenta las siguientes líneas para ver qué está pasando
                // echo '<!-- DEBUG: Found ' . $featured_products->found_posts . ' products -->';
                // echo '<!-- DEBUG: Query: ' . $featured_products->request . ' -->';
                
                if ($featured_products->have_posts()) :
                    while ($featured_products->have_posts()) : $featured_products->the_post();
                        global $product;
                        $product_id = $product->get_id();
                        $categories = wp_get_post_terms($product_id, 'product_cat');
                        $category_name = !empty($categories) ? $categories[0]->name : '';
                        
                        // Get stock status
                        $stock_status = $product->get_stock_status();
                        $stock_quantity = $product->get_stock_quantity();
                        
                        $stock_class = 'in-stock';
                        $stock_text = __('En stock', 'aluria');
                        
                        if ($stock_status === 'outofstock') {
                            $stock_class = 'out-of-stock';
                            $stock_text = __('Agotado', 'aluria');
                        } elseif ($stock_quantity !== null && $stock_quantity <= 3 && $stock_quantity > 0) {
                            $stock_class = 'low-stock';
                            $stock_text = sprintf(__('¡Últimas %d unidades!', 'aluria'), $stock_quantity);
                        }
                        
                        // Check if new (less than 30 days)
                        $post_date = get_the_date('U');
                        $is_new = (time() - $post_date) < (30 * DAY_IN_SECONDS);
                        ?>
                        <article class="product-card" data-product-id="<?php echo esc_attr($product_id); ?>" data-category="<?php echo esc_attr($category_name); ?>">
                            <a href="<?php the_permalink(); ?>" class="product-image">
                                <?php if (has_post_thumbnail()) : 
                                    // Usar imagen grande para mejor calidad
                                    $image_id = get_post_thumbnail_id();
                                    $image_url = wp_get_attachment_image_url($image_id, 'large');
                                    ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php else : ?>
                                    <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                <?php if ($is_new) : ?>
                                    <span class="product-tag"><?php esc_html_e('Nuevo', 'aluria'); ?></span>
                                <?php endif; ?>
                                <span class="stock-badge <?php echo esc_attr($stock_class); ?>"><?php echo esc_html($stock_text); ?></span>
                            </a>
                            <div class="product-info">
                                <h3 class="product-name"><?php the_title(); ?></h3>
                                <p class="product-price"><?php echo $product->get_price_html(); ?></p>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback: mostrar productos de demostración usando imágenes del tema
                    $demo_products = array(
                        array('name' => 'Vestido Cuadros Volante', 'price' => '24,95 €', 'img' => 'vestido-cuadros-volante.png'),
                        array('name' => 'Camisa Cuadros Vichy', 'price' => '20,80 €', 'img' => 'camisa-cuadros-vichy-lazo.jpg'),
                        array('name' => 'Pantalón Palazo Gris', 'price' => '16,00 €', 'img' => 'pantalon-palazo-gris.png'),
                        array('name' => 'Abrigo Sin Manga', 'price' => '26,50 €', 'img' => 'abrigo-sin-manga-pelos.png'),
                    );
                    
                    foreach ($demo_products as $idx => $demo) :
                        $img_url = file_exists(ALURIA_DIR . '/img/productos/' . $demo['img']) 
                            ? ALURIA_URI . '/img/productos/' . $demo['img'] 
                            : (function_exists('wc_placeholder_img_src') ? wc_placeholder_img_src() : '');
                        ?>
                        <article class="product-card" data-product-id="demo-<?php echo $idx; ?>">
                            <a href="<?php echo esc_url(class_exists('WooCommerce') ? get_permalink(wc_get_page_id('shop')) : '#'); ?>" class="product-image">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($demo['name']); ?>">
                                <span class="product-tag"><?php esc_html_e('Nuevo', 'aluria'); ?></span>
                            </a>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo esc_html($demo['name']); ?></h3>
                                <p class="product-price"><?php echo esc_html($demo['price']); ?></p>
                            </div>
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div class="section-cta">
                <?php $shop_page_url = class_exists('WooCommerce') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop/'); ?>
                <a href="<?php echo esc_url($shop_page_url); ?>" class="btn btn-secondary"><?php esc_html_e('Ver todo', 'aluria'); ?></a>
            </div>
        </div>
    </section>

    <!-- Banner Promocional -->
    <section class="promo-banner">
        <div class="promo-content">
            <p class="promo-subtitle"><?php echo esc_html(get_theme_mod('promo_subtitle', 'Oferta especial')); ?></p>
            <h2 class="promo-title"><?php echo esc_html(get_theme_mod('promo_title', 'Envío gratis en pedidos +50€')); ?></h2>
            <p class="promo-description"><?php echo esc_html(get_theme_mod('promo_description', 'Además, devoluciones gratuitas en 30 días')); ?></p>
            <?php 
            $promo_shop_url = class_exists('WooCommerce') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop/');
            $promo_link = get_theme_mod('promo_button_link', $promo_shop_url);
            ?>
            <a href="<?php echo esc_url($promo_link); ?>" class="btn btn-white">
                <?php echo esc_html(get_theme_mod('promo_button_text', 'Comprar ahora')); ?>
            </a>
        </div>
    </section>

    <!-- Por qué elegirnos -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <h3 class="feature-title"><?php esc_html_e('Envío Express', 'aluria'); ?></h3>
                    <p class="feature-text"><?php esc_html_e('Entrega en 24-48h', 'aluria'); ?></p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <polyline points="23 4 23 10 17 10"></polyline>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title"><?php esc_html_e('Devolución fácil', 'aluria'); ?></h3>
                    <p class="feature-text"><?php esc_html_e('30 días para devolver', 'aluria'); ?></p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title"><?php esc_html_e('Pago seguro', 'aluria'); ?></h3>
                    <p class="feature-text"><?php esc_html_e('100% protegido', 'aluria'); ?></p>
                </div>
                <div class="feature">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title"><?php esc_html_e('Atención 24/7', 'aluria'); ?></h3>
                    <p class="feature-text"><?php esc_html_e('Siempre disponibles', 'aluria'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <div class="newsletter-content">
                <h2 class="newsletter-title"><?php esc_html_e('Únete a Aluria', 'aluria'); ?></h2>
                <p class="newsletter-text"><?php esc_html_e('Recibe ofertas exclusivas y novedades directamente en tu correo', 'aluria'); ?></p>
                <form class="newsletter-form" id="newsletterForm" action="" method="post">
                    <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e('Tu email', 'aluria'); ?>" required>
                    <button type="submit" class="btn btn-primary"><?php esc_html_e('Suscribirse', 'aluria'); ?></button>
                    <?php wp_nonce_field('aluria_newsletter', 'newsletter_nonce'); ?>
                </form>
            </div>
        </div>
    </section>

<?php
get_footer();
