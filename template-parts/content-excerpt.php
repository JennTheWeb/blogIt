<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BlogIt
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (has_post_thumbnail() ) : ?>
        <div class="excerpt-thumbnail">
            <?php blogit_post_thumbnail(); ?>
        </div>
    <?php endif; ?>

    <div class="excerpt-content">

        <header class="entry-header">
            <?php 
            the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

            if ( 'post' === get_post_type() ) : ?>
                <div class="entry-meta">
                    <?php
                    blogit_posted_on();
                    blogit_posted_by();
                    ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->
    </div><!-- .excerpt -->

</article><!-- #post-<?php the_ID(); ?> -->
