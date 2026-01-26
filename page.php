<?php
/**
 * The template for displaying all pages
 *
 * @package Aluria
 */

get_header();
?>

<section class="page-header">
    <h1 class="page-title"><?php the_title(); ?></h1>
</section>

<div class="page-content">
    <div class="container">
        <?php
        while (have_posts()) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</div>

<?php
get_footer();
