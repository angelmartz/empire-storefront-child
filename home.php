<?php
/**
 * Blog posts archive
 *
 * Template Name: Blog Archives
 *
 * @package empire-storefront-child
 *
 */

get_header(); ?>

  <section id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) : ?>

      <header class="page-header">
        <h1 class="page-title">Empire Tri Blog</h1>

        <?php the_archive_description(); ?>
      </header><!-- .page-header -->

      <?php get_template_part( 'loop' ); ?>

    <?php else : ?>

      <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>

    </main><!-- #main -->
  </section><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer(); ?>
