<?php
/**
 * The Template for displaying all single products
 *
 * @package Aluria
 */

defined('ABSPATH') || exit;

get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    global $product;
    $product_id = $product->get_id();
    $categories = wp_get_post_terms($product_id, 'product_cat');
    $category_name = !empty($categories) ? $categories[0]->name : '';
    $category_link = !empty($categories) ? get_term_link($categories[0]) : '';
    
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
    
    // Get gallery images
    $gallery_ids = $product->get_gallery_image_ids();
    $main_image_id = $product->get_image_id();
    ?>

    <div class="single-product-page">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('Inicio', 'aluria'); ?></a>
                <span class="separator">/</span>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"><?php esc_html_e('Tienda', 'aluria'); ?></a>
                <?php if ($category_name && $category_link) : ?>
                    <span class="separator">/</span>
                    <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category_name); ?></a>
                <?php endif; ?>
                <span class="separator">/</span>
                <span class="current"><?php the_title(); ?></span>
            </nav>

            <div class="product-detail">
                <!-- Gallery -->
                <div class="product-gallery">
                    <div class="main-image-container">
                        <?php if ($main_image_id) : ?>
                            <img src="<?php echo esc_url(wp_get_attachment_url($main_image_id)); ?>" 
                                 alt="<?php the_title_attribute(); ?>" 
                                 class="main-product-image" 
                                 id="mainProductImage">
                        <?php else : ?>
                            <img src="<?php echo esc_url(wc_placeholder_img_src('full')); ?>" 
                                 alt="<?php the_title_attribute(); ?>" 
                                 class="main-product-image" 
                                 id="mainProductImage">
                        <?php endif; ?>
                        <div class="zoom-lens" id="productZoomLens"></div>
                    </div>
                    <div class="zoom-result" id="productZoomResult"></div>
                    
                    <?php if (!empty($gallery_ids)) : ?>
                        <div class="gallery-thumbnails">
                            <?php if ($main_image_id) : ?>
                                <button class="thumb active" data-image="<?php echo esc_url(wp_get_attachment_url($main_image_id)); ?>">
                                    <img src="<?php echo esc_url(wp_get_attachment_image_url($main_image_id, 'thumbnail')); ?>" alt="">
                                </button>
                            <?php endif; ?>
                            <?php foreach ($gallery_ids as $gallery_id) : ?>
                                <button class="thumb" data-image="<?php echo esc_url(wp_get_attachment_url($gallery_id)); ?>">
                                    <img src="<?php echo esc_url(wp_get_attachment_image_url($gallery_id, 'thumbnail')); ?>" alt="">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Product Info -->
                <div class="product-info-detail">
                    <?php if ($category_name) : ?>
                        <span class="product-category"><?php echo esc_html($category_name); ?></span>
                    <?php endif; ?>
                    
                    <h1 class="product-title-detail"><?php the_title(); ?></h1>
                    
                    <div class="product-price-detail">
                        <?php echo $product->get_price_html(); ?>
                    </div>
                    
                    <div class="stock-status <?php echo esc_attr($stock_class); ?>">
                        <?php echo esc_html($stock_text); ?>
                    </div>
                    
                    <div class="product-description">
                        <?php the_excerpt(); ?>
                    </div>

                    <?php if ($product->is_type('variable')) : ?>
                        <!-- Variable product form -->
                        <?php woocommerce_variable_add_to_cart(); ?>
                    <?php else : ?>
                        <!-- Simple product -->
                        <form class="cart" action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data">
                            <?php woocommerce_quantity_input(array(
                                'min_value' => 1,
                                'max_value' => $product->get_max_purchase_quantity(),
                                'input_value' => 1,
                            )); ?>
                            
                            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>" class="btn btn-primary add-to-cart-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                <?php esc_html_e('Añadir al carrito', 'aluria'); ?>
                            </button>
                        </form>
                    <?php endif; ?>

                    <!-- Product tabs -->
                    <div class="product-tabs">
                        <div class="tabs-nav">
                            <button class="tab-btn active" data-tab="description"><?php esc_html_e('Descripción', 'aluria'); ?></button>
                            <?php if ($product->has_attributes()) : ?>
                                <button class="tab-btn" data-tab="attributes"><?php esc_html_e('Detalles', 'aluria'); ?></button>
                            <?php endif; ?>
                        </div>
                        <div class="tabs-content">
                            <div class="tab-panel active" id="description">
                                <?php the_content(); ?>
                            </div>
                            <?php if ($product->has_attributes()) : ?>
                                <div class="tab-panel" id="attributes">
                                    <?php wc_display_product_attributes($product); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <?php
            $related_products = wc_get_related_products($product_id, 4);
            if (!empty($related_products)) :
            ?>
            <section class="related-products">
                <h2 class="section-title"><?php esc_html_e('También te puede gustar', 'aluria'); ?></h2>
                <div class="products-grid">
                    <?php
                    foreach ($related_products as $related_id) :
                        $related = wc_get_product($related_id);
                        if (!$related) continue;
                        
                        $rel_categories = wp_get_post_terms($related_id, 'product_cat');
                        $rel_category = !empty($rel_categories) ? $rel_categories[0]->name : '';
                        
                        $rel_stock = $related->get_stock_status();
                        $rel_stock_qty = $related->get_stock_quantity();
                        
                        $rel_stock_class = 'in-stock';
                        $rel_stock_text = __('En stock', 'aluria');
                        
                        if ($rel_stock === 'outofstock') {
                            $rel_stock_class = 'out-of-stock';
                            $rel_stock_text = __('Agotado', 'aluria');
                        } elseif ($rel_stock_qty !== null && $rel_stock_qty <= 3 && $rel_stock_qty > 0) {
                            $rel_stock_class = 'low-stock';
                            $rel_stock_text = sprintf(__('¡Últimas %d!', 'aluria'), $rel_stock_qty);
                        }
                        ?>
                        <article class="product-card" data-product-id="<?php echo esc_attr($related_id); ?>" data-category="<?php echo esc_attr($rel_category); ?>">
                            <a href="<?php echo esc_url(get_permalink($related_id)); ?>" class="product-image">
                                <?php echo $related->get_image('woocommerce_thumbnail'); ?>
                                <span class="stock-badge <?php echo esc_attr($rel_stock_class); ?>"><?php echo esc_html($rel_stock_text); ?></span>
                            </a>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo esc_html($related->get_name()); ?></h3>
                                <p class="product-price"><?php echo $related->get_price_html(); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>

<?php
get_footer();
