<?php
/**
 * Member Discount Archive Page
 *
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
          Membership Discounts
        </h1>

      </header><!-- .page-header -->

      <p>Take advantage of our partner discounts.
      As a Member of the Empire Tri Club, you are entitled to discounts from many of our partners and sponsors. Please note that many of our partner shops require you to show your Empire Tri Club Member ID in order to receive discounts. These discounts are for Empire Tri Club Members only, so please use them accordingly so we don’t lose these great privileges!</p>

      <div id='member-discounts'>

      <?php get_template_part( 'loop' ); ?>

      <?php else : ?>

        <?php get_template_part( 'content', 'none' ); ?>

      <?php endif; ?>

    </div>

    </main><!-- #main -->
  </section><!-- #primary -->

<?php get_footer(); ?>