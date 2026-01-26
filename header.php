<?php
/**
 * Header Template
 *
 * @package Aluria
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-left">
                <button class="menu-toggle" id="menuToggle" aria-label="<?php esc_attr_e('Menú', 'aluria'); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="nav-center">
                <?php aluria_custom_logo(); ?>
            </div>
            <div class="nav-right">
                <button type="button" class="nav-icon search-toggle" id="searchToggle" aria-label="<?php esc_attr_e('Buscar', 'aluria'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
                <?php if (class_exists('WooCommerce')) : ?>
                <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="nav-icon" aria-label="<?php esc_attr_e('Mi Cuenta', 'aluria'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <?php endif; ?>
                <?php if (function_exists('wc_get_cart_url')) : ?>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="nav-icon cart-icon" aria-label="<?php esc_attr_e('Carrito', 'aluria'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span class="cart-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?></span>
                </a>
                <?php endif; ?>
            </div>
        </nav>
        
        <!-- Desktop Menu -->
        <div class="nav-menu">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav-links',
                ));
            } else {
                // Fallback: mostrar categorías de WooCommerce como menú
                echo '<ul class="nav-links">';
                if (class_exists('WooCommerce')) {
                    echo '<li><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">Catálogo</a></li>';
                    $categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 5));
                    if (!is_wp_error($categories)) {
                        foreach ($categories as $cat) {
                            echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
                        }
                    }
                }
                echo '</ul>';
            }
            ?>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <?php
        // Primero intenta el menú móvil, si no existe usa el primario
        if (has_nav_menu('mobile')) {
            wp_nav_menu(array(
                'theme_location' => 'mobile',
                'container' => false,
                'menu_class' => 'mobile-nav-links',
            ));
        } elseif (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'mobile-nav-links',
            ));
        } else {
            // Fallback con categorías de WooCommerce
            echo '<ul class="mobile-nav-links">';
            if (class_exists('WooCommerce')) {
                echo '<li><a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">Catálogo</a></li>';
                $categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 5));
                if (!is_wp_error($categories)) {
                    foreach ($categories as $cat) {
                        echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
                    }
                }
            }
            echo '</ul>';
        }
        ?>
    </div>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-container">
            <div class="search-header">
                <button class="search-close" id="searchClose" aria-label="<?php esc_attr_e('Cerrar', 'aluria'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="search-input-wrapper">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" class="search-input" id="searchInput" name="s" placeholder="<?php esc_attr_e('¿Qué estás buscando?', 'aluria'); ?>" value="<?php echo get_search_query(); ?>">
                    <input type="hidden" name="post_type" value="product">
                </form>
            </div>
            <div class="search-results" id="searchResults"></div>
        </div>
    </div>

    <main id="main" class="site-main">
