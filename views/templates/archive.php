<?php
/**
 * Template Name: Contactos
 *
 * Description: Plantilla pagina de Contactos
 */
get_header(); ?>

<?php echo 'Archive (plugin)'; // BORRAR !!!!! ?>

<section id="primary" class="site-content span12" role="main">

    <section class="content row wrap">

        <?php if ( have_posts() ) : ?>

            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <?php //get_template_part( 'content', get_post_type() ); ?>
                <?php include( PTC_PLUGIN_ROOT . 'views/templates/content.php' ); ?>

            <?php endwhile; ?>

        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>

    </section> <!-- .content -->
</section> <!-- #primary -->

<?php get_footer(); ?>
