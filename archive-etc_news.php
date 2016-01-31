<?php
/**
 * In the News Archive Page
 *
 * Template Name: News Archives
 *
 * @package empire-storefront-child
 *
 */

get_header(); ?>

  <section id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php if ( have_posts() ) :?>

      <header class="page-header">
        <h1 class="page-title">
          Empire in the News
        </h1>

      </header><!-- .page-header -->

      <div id='in-the-news'>

      <?php get_template_part( 'loop' ); ?>

      <?php else : ?>

        <?php get_template_part( 'content', 'none' ); ?>

      <?php endif; ?>

    </div>

    </main><!-- #main -->
  </section><!-- #primary -->

<?php get_footer(); ?>