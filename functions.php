<?php
/**
 * Aluria Modas Theme Functions
 *
 * @package Aluria
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define Constants
 */
define('ALURIA_VERSION', '1.1.4');
define('ALURIA_DIR', get_template_directory());
define('ALURIA_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function aluria_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    add_image_size('aluria-product', 600, 800, true);
    add_image_size('aluria-category', 450, 600, true);
    add_image_size('aluria-hero', 1200, 800, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Menú Principal', 'aluria'),
        'mobile' => __('Menú Móvil', 'aluria'),
        'footer-1' => __('Footer - Tienda', 'aluria'),
        'footer-2' => __('Footer - Ayuda', 'aluria'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 90,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // WooCommerce support - Imágenes de alta calidad
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 800,
        'single_image_width'    => 1200,
        'product_grid'          => array(
            'default_rows'    => 4,
            'default_columns' => 4,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Add support for Block Styles
    add_theme_support('wp-block-styles');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'aluria_setup');

/**
 * Set the content width
 */
function aluria_content_width() {
    $GLOBALS['content_width'] = apply_filters('aluria_content_width', 1400);
}
add_action('after_setup_theme', 'aluria_content_width', 0);

/**
 * Register widget areas
 */
function aluria_widgets_init() {
    // Footer Column 1 - About
    register_sidebar(array(
        'name'          => __('Footer - Sobre Nosotros', 'aluria'),
        'id'            => 'footer-1',
        'description'   => __('Añade widgets para la primera columna del footer.', 'aluria'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-title">',
        'after_title'   => '</h4>',
    ));

    // Footer Column 2 - Shop
    register_sidebar(array(
        'name'          => __('Footer - Tienda', 'aluria'),
        'id'            => 'footer-2',
        'description'   => __('Añade widgets para la columna de tienda del footer.', 'aluria'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-title">',
        'after_title'   => '</h4>',
    ));

    // Footer Column 3 - Help
    register_sidebar(array(
        'name'          => __('Footer - Ayuda', 'aluria'),
        'id'            => 'footer-3',
        'description'   => __('Añade widgets para la columna de ayuda del footer.', 'aluria'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-title">',
        'after_title'   => '</h4>',
    ));

    // Footer Column 4 - Contact
    register_sidebar(array(
        'name'          => __('Footer - Contacto', 'aluria'),
        'id'            => 'footer-4',
        'description'   => __('Añade widgets para la columna de contacto del footer.', 'aluria'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title footer-title">',
        'after_title'   => '</h4>',
    ));

    // Sidebar
    register_sidebar(array(
        'name'          => __('Barra Lateral', 'aluria'),
        'id'            => 'sidebar-1',
        'description'   => __('Añade widgets a la barra lateral.', 'aluria'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'aluria_widgets_init');

/**
 * Enqueue scripts and styles
 */
function aluria_scripts() {
    // Google Fonts
    wp_enqueue_style('aluria-google-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600&display=swap', array(), null);

    // Main stylesheet
    wp_enqueue_style('aluria-style', get_stylesheet_uri(), array(), ALURIA_VERSION);

    // Pages stylesheet
    wp_enqueue_style('aluria-pages', ALURIA_URI . '/css/pages.css', array('aluria-style'), ALURIA_VERSION);

    // Main JavaScript
    wp_enqueue_script('aluria-main', ALURIA_URI . '/js/main.js', array(), ALURIA_VERSION, true);

    // WooCommerce JavaScript (if WooCommerce is active)
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('aluria-woocommerce', ALURIA_URI . '/js/woocommerce.js', array('jquery', 'aluria-main'), ALURIA_VERSION, true);
    }

    // Localize script for AJAX
    wp_localize_script('aluria-main', 'aluria_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('aluria_nonce'),
        'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '',
        'checkout_url' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '',
    ));

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'aluria_scripts');

/**
 * Custom Logo
 */
function aluria_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url(home_url('/')) . '" class="logo">';
        if (file_exists(ALURIA_DIR . '/img/logo.png')) {
            echo '<img src="' . ALURIA_URI . '/img/logo.png" alt="' . get_bloginfo('name') . '" class="logo-img">';
        } else {
            echo '<span>' . get_bloginfo('name') . '</span>';
        }
        echo '</a>';
    }
}

/**
 * WooCommerce Support
 */
function aluria_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'aluria_woocommerce_support');

/**
 * Change number of products per row
 */
add_filter('loop_shop_columns', function() {
    return 4;
});

/**
 * Change number of products displayed per page
 */
add_filter('loop_shop_per_page', function() {
    return 12;
});

/**
 * Remove WooCommerce default styles
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * WooCommerce Cart Count (AJAX)
 */
function aluria_cart_count_fragments($fragments) {
    $fragments['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'aluria_cart_count_fragments');

/**
 * Customizer Settings
 */
function aluria_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('aluria_hero', array(
        'title' => __('Sección Hero', 'aluria'),
        'priority' => 30,
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Nueva Colección',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Subtítulo Hero', 'aluria'),
        'section' => 'aluria_hero',
        'type' => 'text',
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Aluria 2026',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_title', array(
        'label' => __('Título Hero', 'aluria'),
        'section' => 'aluria_hero',
        'type' => 'text',
    ));

    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default' => 'Tu moda cómoda y actual para cada día',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_description', array(
        'label' => __('Descripción Hero', 'aluria'),
        'section' => 'aluria_hero',
        'type' => 'textarea',
    ));

    // Hero Image
    $wp_customize->add_setting('hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label' => __('Imagen Hero', 'aluria'),
        'section' => 'aluria_hero',
    )));

    // Hero Button Text
    $wp_customize->add_setting('hero_button_text', array(
        'default' => 'Ver catálogo',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_button_text', array(
        'label' => __('Texto del Botón', 'aluria'),
        'section' => 'aluria_hero',
        'type' => 'text',
    ));

    // Hero Button Link
    $wp_customize->add_setting('hero_button_link', array(
        'default' => '/tienda',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_button_link', array(
        'label' => __('Enlace del Botón', 'aluria'),
        'section' => 'aluria_hero',
        'type' => 'url',
    ));

    // Promo Banner Section
    $wp_customize->add_section('aluria_promo', array(
        'title' => __('Banner Promocional', 'aluria'),
        'priority' => 35,
    ));

    // Promo Subtitle
    $wp_customize->add_setting('promo_subtitle', array(
        'default' => 'Oferta especial',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('promo_subtitle', array(
        'label' => __('Subtítulo Promoción', 'aluria'),
        'section' => 'aluria_promo',
        'type' => 'text',
    ));

    // Promo Title
    $wp_customize->add_setting('promo_title', array(
        'default' => 'Envío gratis en pedidos +50€',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('promo_title', array(
        'label' => __('Título Promoción', 'aluria'),
        'section' => 'aluria_promo',
        'type' => 'text',
    ));

    // Promo Description
    $wp_customize->add_setting('promo_description', array(
        'default' => 'Además, devoluciones gratuitas en 30 días',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('promo_description', array(
        'label' => __('Descripción Promoción', 'aluria'),
        'section' => 'aluria_promo',
        'type' => 'textarea',
    ));

    // Contact Section
    $wp_customize->add_section('aluria_contact', array(
        'title' => __('Información de Contacto', 'aluria'),
        'priority' => 40,
    ));

    // Email
    $wp_customize->add_setting('contact_email', array(
        'default' => 'info@aluriamodas.es',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('contact_email', array(
        'label' => __('Email de Contacto', 'aluria'),
        'section' => 'aluria_contact',
        'type' => 'email',
    ));

    // Phone
    $wp_customize->add_setting('contact_phone', array(
        'default' => '620 932 637',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_phone', array(
        'label' => __('Teléfono', 'aluria'),
        'section' => 'aluria_contact',
        'type' => 'text',
    ));

    // WhatsApp
    $wp_customize->add_setting('contact_whatsapp', array(
        'default' => '34620932637',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_whatsapp', array(
        'label' => __('WhatsApp (sin espacios)', 'aluria'),
        'section' => 'aluria_contact',
        'type' => 'text',
    ));

    // Location
    $wp_customize->add_setting('contact_location', array(
        'default' => 'Sevilla, España',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('contact_location', array(
        'label' => __('Ubicación', 'aluria'),
        'section' => 'aluria_contact',
        'type' => 'text',
    ));

    // Social Media Section
    $wp_customize->add_section('aluria_social', array(
        'title' => __('Redes Sociales', 'aluria'),
        'priority' => 45,
    ));

    // Instagram
    $wp_customize->add_setting('social_instagram', array(
        'default' => 'https://www.instagram.com/aluriamodas/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_instagram', array(
        'label' => __('Instagram URL', 'aluria'),
        'section' => 'aluria_social',
        'type' => 'url',
    ));

    // TikTok
    $wp_customize->add_setting('social_tiktok', array(
        'default' => 'https://www.tiktok.com/@aluria.modas',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_tiktok', array(
        'label' => __('TikTok URL', 'aluria'),
        'section' => 'aluria_social',
        'type' => 'url',
    ));

    // Facebook
    $wp_customize->add_setting('social_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_facebook', array(
        'label' => __('Facebook URL', 'aluria'),
        'section' => 'aluria_social',
        'type' => 'url',
    ));
}
add_action('customize_register', 'aluria_customize_register');

/**
 * Get Theme Mod Helper
 */
function aluria_get_option($key, $default = '') {
    return get_theme_mod($key, $default);
}

/**
 * Add body classes
 */
function aluria_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    
    if (class_exists('WooCommerce')) {
        if (is_shop()) {
            $classes[] = 'shop-page';
        }
        if (is_product()) {
            $classes[] = 'product-page';
        }
        if (is_cart()) {
            $classes[] = 'cart-page';
        }
        if (is_checkout()) {
            $classes[] = 'checkout-page';
        }
    }
    
    return $classes;
}
add_filter('body_class', 'aluria_body_classes');

/**
 * Modify WooCommerce breadcrumb
 */
add_filter('woocommerce_breadcrumb_defaults', function($defaults) {
    $defaults['delimiter'] = ' <span class="breadcrumb-separator">/</span> ';
    $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb breadcrumb">';
    $defaults['wrap_after'] = '</nav>';
    return $defaults;
});

/**
 * Include template parts
 */
function aluria_get_template_part($slug, $name = null) {
    get_template_part('template-parts/' . $slug, $name);
}

/**
 * Check if WooCommerce is active
 */
function aluria_is_woocommerce_active() {
    return class_exists('WooCommerce');
}

/**
 * WhatsApp Floating Button
 */
function aluria_whatsapp_button() {
    $whatsapp = aluria_get_option('contact_whatsapp', '34620932637');
    if ($whatsapp) :
    ?>
    <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
        <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>
    <?php
    endif;
}
add_action('wp_footer', 'aluria_whatsapp_button');

/**
 * AJAX Quick View - Get Product Data
 */
function aluria_quick_view_ajax() {
    check_ajax_referer('aluria_nonce', 'nonce');
    
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    
    if (!$product_id) {
        wp_send_json_error(array('message' => 'Invalid product ID'));
    }
    
    $product = wc_get_product($product_id);
    
    if (!$product) {
        wp_send_json_error(array('message' => 'Product not found'));
    }
    
    // Get categories
    $categories = wp_get_post_terms($product_id, 'product_cat');
    $category_name = !empty($categories) ? $categories[0]->name : '';
    
    // Get stock info
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
    
    // Get attributes
    $attributes = array();
    if ($product->is_type('variable')) {
        foreach ($product->get_variation_attributes() as $attr_name => $options) {
            $attributes[$attr_name] = $options;
        }
    }
    
    $data = array(
        'id' => $product_id,
        'name' => $product->get_name(),
        'price' => $product->get_price_html(),
        'image' => wp_get_attachment_url($product->get_image_id()),
        'category' => $category_name,
        'short_description' => $product->get_short_description(),
        'permalink' => get_permalink($product_id),
        'stock_status' => $stock_status,
        'stock_class' => $stock_class,
        'stock_text' => $stock_text,
        'attributes' => $attributes,
        'add_to_cart_url' => $product->add_to_cart_url(),
    );
    
    wp_send_json_success($data);
}
add_action('wp_ajax_aluria_quick_view', 'aluria_quick_view_ajax');
add_action('wp_ajax_nopriv_aluria_quick_view', 'aluria_quick_view_ajax');

/**
 * AJAX Add to Cart Handler
 */
function aluria_ajax_add_to_cart() {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $variation = isset($_POST['variation']) ? (array) $_POST['variation'] : array();
    
    if ($variation_id) {
        WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);
    } else {
        WC()->cart->add_to_cart($product_id, $quantity);
    }
    
    wp_send_json(array(
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'cart_total' => WC()->cart->get_cart_total(),
    ));
}
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'aluria_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'aluria_ajax_add_to_cart');

/**
 * Product Search AJAX
 */
function aluria_product_search_ajax() {
    $search_query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
    
    if (strlen($search_query) < 2) {
        wp_send_json(array('results' => array()));
    }
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        's' => $search_query,
        'post_status' => 'publish',
    );
    
    $products = new WP_Query($args);
    $results = array();
    
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());
            
            $results[] = array(
                'id' => get_the_ID(),
                'name' => get_the_title(),
                'price' => $product->get_price_html(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'url' => get_permalink(),
            );
        }
        wp_reset_postdata();
    } else {
        // Fallback: buscar en productos de demostración
        $demo_products = array(
            array('name' => 'Vestido Cuadros Volante', 'price' => '24,95 €', 'category' => 'Vestidos', 'img' => 'vestido-cuadros-volante.png'),
            array('name' => 'Camisa Cuadros Vichy Lazo', 'price' => '20,80 €', 'category' => 'Blusas', 'img' => 'camisa-cuadros-vichy-lazo.jpg'),
            array('name' => 'Camiseta Hombreras', 'price' => '11,00 €', 'category' => 'Blusas', 'img' => 'camiseta-hombreras.jpg'),
            array('name' => 'Jersey Palmera', 'price' => '21,80 €', 'category' => 'Blusas', 'img' => 'jersey-palmera.png'),
            array('name' => 'Sudadera Tachuelas', 'price' => '15,50 €', 'category' => 'Blusas', 'img' => 'sudadera-tachuelas.png'),
            array('name' => 'Pantalón Palazo Gris', 'price' => '16,00 €', 'category' => 'Pantalones', 'img' => 'pantalon-palazo-gris.png'),
            array('name' => 'Jeans Negro Tachuelas', 'price' => '23,80 €', 'category' => 'Pantalones', 'img' => 'jeans-negro-tachuelas.jpg'),
            array('name' => 'Bermuda Soft Chocolate', 'price' => '14,90 €', 'category' => 'Pantalones', 'img' => 'bermuda-soft-chocolate.png'),
            array('name' => 'Falda Cuadros', 'price' => '19,95 €', 'category' => 'Pantalones', 'img' => 'falda-cuadros.png'),
            array('name' => 'Abrigo Sin Manga Pelos', 'price' => '26,50 €', 'category' => 'Complementos', 'img' => 'abrigo-sin-manga-pelos.png'),
            array('name' => 'Chaleco Tachuelas', 'price' => '17,95 €', 'category' => 'Complementos', 'img' => 'chaleco-tachuelas.png'),
            array('name' => 'Chaqueta Paño Ribete', 'price' => '23,95 €', 'category' => 'Complementos', 'img' => 'chaqueta-pano-ribete-burdeos.jpg'),
            array('name' => 'Conjunto Casual', 'price' => '23,95 €', 'category' => 'Complementos', 'img' => 'conjunto-casual.png'),
            array('name' => 'Conjunto Sport', 'price' => '19,95 €', 'category' => 'Complementos', 'img' => 'conjunto-sport.png'),
        );
        
        $search_lower = strtolower($search_query);
        $shop_url = class_exists('WooCommerce') ? get_permalink(wc_get_page_id('shop')) : home_url('/');
        
        foreach ($demo_products as $demo) {
            if (stripos($demo['name'], $search_query) !== false || 
                stripos($demo['category'], $search_query) !== false) {
                $results[] = array(
                    'id' => 'demo',
                    'name' => $demo['name'],
                    'price' => $demo['price'],
                    'image' => ALURIA_URI . '/img/productos/' . $demo['img'],
                    'url' => $shop_url,
                );
            }
            
            if (count($results) >= 6) break;
        }
    }
    
    wp_send_json(array('results' => $results));
}
add_action('wp_ajax_aluria_product_search', 'aluria_product_search_ajax');
add_action('wp_ajax_nopriv_aluria_product_search', 'aluria_product_search_ajax');

/**
 * AJAX: Get Cart Count
 */
function aluria_get_cart_count_ajax() {
    $count = 0;
    if (class_exists('WooCommerce') && WC()->cart) {
        $count = WC()->cart->get_cart_contents_count();
    }
    wp_send_json(array('count' => $count));
}
add_action('wp_ajax_aluria_get_cart_count', 'aluria_get_cart_count_ajax');
add_action('wp_ajax_nopriv_aluria_get_cart_count', 'aluria_get_cart_count_ajax');

/**
 * Forzar imágenes de mayor tamaño en el catálogo de WooCommerce
 */
function aluria_woocommerce_image_size_gallery_thumbnail($size) {
    return 'large';
}
add_filter('woocommerce_gallery_thumbnail_size', 'aluria_woocommerce_image_size_gallery_thumbnail');

function aluria_woocommerce_image_size_thumbnail($size) {
    return 'large';
}
add_filter('woocommerce_product_loop_start', function() {
    add_filter('post_thumbnail_size', 'aluria_woocommerce_image_size_thumbnail');
});
add_filter('woocommerce_product_loop_end', function() {
    remove_filter('post_thumbnail_size', 'aluria_woocommerce_image_size_thumbnail');
});
