<?php
/**
 * Empire Tri Homepage
 *
 *
 * @package empire-storefront-child
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="empire-homepage hfeed site">
  <?php
  do_action( 'storefront_before_header' ); ?>

  <header id="masthead" class="site-header" role="banner" <?php if ( get_header_image() != '' ) { echo 'style="background-image: url(' . esc_url( get_header_image() ) . ');"'; } ?>>
    <div class="col-full">

      <?php
      /**
       * @hooked storefront_skip_links - 0
       * @hooked storefront_social_icons - 10
       * @hooked storefront_site_branding - 20
       * @hooked storefront_secondary_navigation - 30
       * @hooked storefront_product_search - 40
       * @hooked storefront_primary_navigation - 50
       * @hooked storefront_header_cart - 60
       */
      do_action( 'storefront_header' ); ?>

    </div>
  </header><!-- #masthead -->

  <?php
  /**
   * @hooked storefront_header_widget_region - 10
   */
  do_action( 'storefront_before_content' ); ?>

  <div id="content" class="site-content" tabindex="-1">
    <?php 
      $user_id = get_current_user_id();

      // Check if the user is member of the plan 'gold'
      if ( !wc_memberships_is_user_active_member( $user_id, 'empire-tri-membership' ) ) {
        do_action( 'etc_call_to_join' );
      } 
    ?>
    <div id='featured-carousel' class="col-full">
      <div id='featured-carousel-content' class='owl-carousel'>
        
        <?php

        do_action( 'empire_homepage_featured' ); 

        ?>

      </div><!-- #featured-carousel-content -->

      <?php 
        /**
         * @hooked woocommerce_breadcrumb - 10
         */
        do_action( 'storefront_content_top' );
      ?>
    </div><!-- #featured-carousel -->


  <div id="primary" class="site-content">
    <main id="buckets" class="site-main col-full" role="main">

    <?php 
      do_action( 'empire_homepage_buckets' );
    ?>

    </main><!-- #main -->
  </div><!-- #primary -->
<?php get_footer(); ?>
