<?php
/**
 * Product Card Template Part
 * 
 * Variables disponibles:
 * $product, $product_id, $category_name, $stock_class, $stock_text, $is_on_sale, $is_new
 *
 * @package Aluria
 */

defined('ABSPATH') || exit;
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
