<?php
/**
 * The template for displaying search results pages
 *
 * @package Aluria
 */

get_header();
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title">
            <?php
            printf(
                /* translators: %s: search query */
                esc_html__('Resultados de búsqueda: "%s"', 'aluria'),
                '<span>' . get_search_query() . '</span>'
            );
            ?>
        </h1>
    </div>
</section>

<div class="search-results-page">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="products-grid">
                <?php
                while (have_posts()) : the_post();
                    if (get_post_type() === 'product') :
                        global $product;
                        $product_id = $product->get_id();
                        $categories = wp_get_post_terms($product_id, 'product_cat');
                        $category_name = !empty($categories) ? $categories[0]->name : '';
                        
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
                        ?>
                        <article class="product-card" data-product-id="<?php echo esc_attr($product_id); ?>" data-category="<?php echo esc_attr($category_name); ?>">
                            <a href="<?php the_permalink(); ?>" class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('woocommerce_thumbnail'); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                <span class="stock-badge <?php echo esc_attr($stock_class); ?>"><?php echo esc_html($stock_text); ?></span>
                            </a>
                            <div class="product-info">
                                <h3 class="product-name"><?php the_title(); ?></h3>
                                <p class="product-price"><?php echo $product->get_price_html(); ?></p>
                            </div>
                        </article>
                    <?php else : ?>
                        <article class="post-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            <?php endif; ?>
                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <div class="no-results">
                <h2><?php esc_html_e('No se encontraron resultados', 'aluria'); ?></h2>
                <p><?php esc_html_e('Lo sentimos, no hay productos que coincidan con tu búsqueda.', 'aluria'); ?></p>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-primary">
                    <?php esc_html_e('Ver todos los productos', 'aluria'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
