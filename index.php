<?php
/**
 * The main template file
 *
 * @package Aluria
 */

get_header();
?>

<?php if (have_posts()) : ?>
    <div class="container">
        <div class="posts-grid">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>
                    <?php endif; ?>
                    <div class="post-content">
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn-secondary"><?php esc_html_e('Leer más', 'aluria'); ?></a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        
        <?php the_posts_navigation(); ?>
    </div>
<?php else : ?>
    <div class="container">
        <div class="no-results">
            <h2><?php esc_html_e('No se encontraron resultados', 'aluria'); ?></h2>
            <p><?php esc_html_e('Lo sentimos, no hay contenido que mostrar.', 'aluria'); ?></p>
        </div>
    </div>
<?php endif; ?>

<?php
get_footer();
