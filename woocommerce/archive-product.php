<?php
/**
 * The Template for displaying product archives
 *
 * @package Aluria
 */

defined('ABSPATH') || exit;

get_header();

// Get current category
$current_category = get_queried_object();
$category_name = is_product_category() ? $current_category->name : __('Catálogo', 'aluria');
$category_description = is_product_category() ? $current_category->description : '';
?>

<!-- Page Header -->
<section class="page-header">
    <h1 class="page-title"><?php echo esc_html($category_name); ?></h1>
    <?php if ($category_description) : ?>
        <p class="page-description"><?php echo wp_kses_post($category_description); ?></p>
    <?php endif; ?>
</section>

<div class="catalog-page">
    <div class="container">
        <!-- Filters -->
        <div class="filters-bar">
            <div class="filters-left">
                <!-- Category Filter Buttons -->
                <div class="filter-group filter-buttons">
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" 
                       class="filter-btn <?php echo is_shop() && !is_product_category() ? 'active' : ''; ?>">
                        <?php esc_html_e('Todo', 'aluria'); ?>
                    </a>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => 0,
                        'exclude' => array(get_option('default_product_cat')),
                    ));
                    
                    foreach ($categories as $cat) :
                        $is_active = is_product_category($cat->slug) ? 'active' : '';
                        ?>
                        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="filter-btn <?php echo $is_active; ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="filters-right">
                <!-- Sort -->
                <div class="sort-group">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="products-grid catalog-grid">
            <?php
            // Intentar primero con la query de WooCommerce
            $has_products = woocommerce_product_loop();
            
            // Si WooCommerce no devuelve productos, hacer query directa
            if (!$has_products) {
                $current_cat = get_queried_object();
                $cat_args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 12,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                
                // Si estamos en una categoría, filtrar por ella
                if (is_product_category() && $current_cat) {
                    $cat_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => $current_cat->term_id,
                        ),
                    );
                }
                
                $custom_products = new WP_Query($cat_args);
                $has_products = $custom_products->have_posts();
                
                // DEBUG: Descomenta para diagnosticar
                // echo '<!-- DEBUG Archive: WooCommerce loop empty, custom query found ' . $custom_products->found_posts . ' products -->';
            }
            
            if ($has_products) :
                // Si usamos la query custom, iterar sobre ella
                if (isset($custom_products) && $custom_products->have_posts()) :
                    while ($custom_products->have_posts()) : $custom_products->the_post();
                        global $product;
                        $product = wc_get_product(get_the_ID());
                        if (!$product) continue;
                        
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
                        
                        $is_on_sale = $product->is_on_sale();
                        $post_date = get_the_date('U');
                        $is_new = (time() - $post_date) < (30 * DAY_IN_SECONDS);
                        
                        // Incluir template de producto
                        include(locate_template('woocommerce/content-product-card.php', false, false));
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Usar el loop estándar de WooCommerce
                    while (have_posts()) : the_post();
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
                    
                    // Check if on sale
                    $is_on_sale = $product->is_on_sale();
                    
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
                            <?php if ($is_on_sale) : ?>
                                <span class="product-tag sale"><?php esc_html_e('Oferta', 'aluria'); ?></span>
                            <?php elseif ($is_new) : ?>
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
                endif; // Fin del else (loop WooCommerce estándar)
            else :
                ?>
                <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; background: var(--color-soft-pink); border-radius: 12px;">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="color: var(--color-primary); margin-bottom: 20px;">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <h3 style="font-family: var(--font-heading); font-size: 2rem; font-weight: 400; margin-bottom: 15px; color: var(--color-dark);"><?php esc_html_e('Próximamente', 'aluria'); ?></h3>
                    <p style="color: var(--color-gray); margin-bottom: 25px; max-width: 400px; margin-left: auto; margin-right: auto;"><?php esc_html_e('Estamos preparando productos increíbles para ti. ¡Vuelve pronto para descubrir nuestra colección!', 'aluria'); ?></p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php esc_html_e('Volver al inicio', 'aluria'); ?></a>
                </div>
                <?php
            endif;
            ?>
        </div>

        <!-- Pagination -->
        <?php woocommerce_pagination(); ?>
    </div>
</div>

<?php
get_footer();
