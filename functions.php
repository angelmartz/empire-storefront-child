<?php

/**
 * Empire Tri storefront child theme functions.php file.
 *
 * @package empire-storefront-child
 */

// Establish relationship between parent and child themes
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// Enable custom logo
add_action( 'init', 'storefront_custom_logo' );

// Custom Homepage
add_action( 'empire_homepage_featured', 'empire_homepage_featured');
// add_action( 'empire_homepage', 'empire_homepage_featured');
// add_action( 'empire_homepage', 'empire_homepage_featured');

// Disable text header and enable custom logo
function storefront_custom_logo() {
  remove_action( 'storefront_header', 'storefront_site_branding', 20 );
  add_action( 'storefront_header', 'storefront_display_custom_logo', 20 );
}

// Add custom logo
function storefront_display_custom_logo() {
?>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-link" rel="home">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="<?php echo get_bloginfo( 'name' ); ?>" />
    <?php if ( '' != get_bloginfo( 'description' ) ) { ?>
      <p class="site-description"><?php echo bloginfo( 'description' ); ?></p>
    <?php } ?>
  </a>
<?php
}

// Get featured content for the homepage
function empire_homepage_featured() {

  $args = array(
    'category_name'    => 'featured',
    'post_type'   => 'post'
  );

  // $q = new WP_Query( $args );

  // while ( $q->have_posts() ) {
  //     $q->the_post();

  //      echo '<div class="hey">' . the_title() . '<div>';

  //      // whatever
  // }

  // wp_reset_postdata();

  $posts_array = get_posts( $args );

  foreach ( $posts_array as $key => $post ) { 

    setup_postdata( $post );
    $background_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

    echo '<div id="' . $key . '" class="carousel-item" style="background-image: url(' . $background_image_url . ')"><div class="carousel-item-content"><div class="border"><div class="background"><a href="' . get_permalink($post->ID) . '"><h1>' . $post->post_title . '</h1>';
    echo '<p>' . $post->post_excerpt . '</p></div></a></div></div></div>';

    }

    wp_reset_postdata();

  }

// Replace "Navigation" text with "Menu" on mobile devices
function storefront_primary_navigation() {
  ?>
  <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
  <button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false"><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></button>
    <?php
    wp_nav_menu(
      array(
        'theme_location'  => 'primary',
        'container_class' => 'primary-navigation',
        )
    );

    wp_nav_menu(
      array(
        'theme_location'  => 'handheld',
        'container_class' => 'handheld-navigation',
        )
    );?>
  </nav><!-- #site-navigation -->
  <?php }