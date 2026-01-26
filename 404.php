<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Aluria
 */

get_header();
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title"><?php esc_html_e('404', 'aluria'); ?></h1>
    </div>
</section>

<div class="error-404-page">
    <div class="container">
        <div class="error-content">
            <div class="error-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M16 16s-1.5-2-4-2-4 2-4 2"></path>
                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                </svg>
            </div>
            <h2><?php esc_html_e('Página no encontrada', 'aluria'); ?></h2>
            <p><?php esc_html_e('Lo sentimos, la página que buscas no existe o ha sido movida.', 'aluria'); ?></p>
            
            <div class="error-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Ir al inicio', 'aluria'); ?>
                </a>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-secondary">
                    <?php esc_html_e('Ver tienda', 'aluria'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
