<?php echo 'Content (plugin)'; // BORRAR !!!!! ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
            <?php if ( ! is_sticky() && ! is_single() ) : ?>
                <?php if ( has_post_thumbnail() ) : ?>

                <figure class="entry-thumbnail">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'aligncenter' ) ); ?></a>
                </figure>

                <?php endif; // has_thubnail() ?>
            <?php endif; // ! is_sticky() ?>

            <?php if ( is_single() ) : ?>
                <?php if ( has_post_thumbnail() ) : ?>

                <figure class="entry-thumbnail">
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'aligncenter' ) ); ?>
                </figure>

                <?php endif; // has_thubnail() ?>
            <?php endif; // is_single() ?>

            <?php if ( is_single() ) : ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php else: ?>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </h2>
            <?php endif; // is_single() ?>
        </header> <!-- header.entry-header -->

        <section class="entry-content">
            <?php if ( is_sticky() && ! is_single() ) : ?>
                <?php if ( has_post_thumbnail() ) : ?>

                <figure class="entry-thumbnail">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ); ?></a>
                </figure>

                <?php endif; // has_thubnail() ?>
            <?php endif; // is_sticky() ?>

            <?php if ( is_single() ) : ?>
                <?php the_content(); ?>
            <?php else : ?>
                <?php the_excerpt(); ?>
            <?php endif; // is_single() ?>
        </section> <!-- section.entry-content -->

        <footer class="entry-meta">
            <?php custom_taxonomies_terms( ); // Display terms ?>

            <?php if ( ! is_sticky() || is_single() ) : ?>

            <br>
            <?php
            $display_meta = new Contactos_Post_Public();
            $display_meta->get_meta( array(
                '_email'              => 'Email',
                '_telephone'          => 'Teléfono',
                '_social_facebook'    => '',
                '_social_twitter'     => '',
                '_social_google_plus' => ''
            ) );
            ?>

            <?php endif; // ! is_sticky() ?>
        </footer> <!-- footer.entry-meta -->

        <!--<hr>-->

    </article> <!-- article.post -->
