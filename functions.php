<?php

/**
 * Empire Tri storefront child theme functions.php file.
 *
 * @package empire-storefront-child
 */

// Replace main nav text on mobile
add_filter( 'storefront_menu_toggle_text', function($text) { return 'Menu'; } );

add_action( 'after_setup_theme', function() {
  remove_action( 'storefront_header', 'storefront_site_branding', 20 );
  remove_action( 'storefront_header', 'storefront_secondary_navigation', 30); // remove storefront secondary nav
  remove_action( 'storefront_header', 'storefront_product_search', 40 ); // remove search bar
  remove_action( 'storefront_footer', 'storefront_credit',     20 );
  add_action( 'storefront_header', 'storefront_display_custom_logo', 20 );
  add_action( 'storefront_header', 'etc_secondary_navigation', 30); // add custom secondary nav
  add_action( 'storefront_footer', 'etc_credit', 20); // add empire copyright
});

// Establish relationship between parent and child themes
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// Add carousel script
function load_homepage_javascript_files() {
  if(is_front_page()) { // conditionally enqueue carousel script (homepage only)
    wp_enqueue_script('jquery');
    wp_enqueue_script('carousel_script', get_stylesheet_directory_uri() . '/js/carousel.js', true );
    wp_enqueue_script('owl_carousel_script', get_stylesheet_directory_uri() . '/owl-carousel/owl.carousel.js', true );
  }
}

add_action( 'wp_enqueue_scripts', 'load_homepage_javascript_files' );

function load_additional_scripts() {
  wp_enqueue_script('tables_script', get_stylesheet_directory_uri() . '/js/tables.js', true );
}

add_action( 'wp_enqueue_scripts', 'load_additional_scripts' );


// Load stylesheets for Owl carousel
function load_stylesheets() {
  if(is_front_page()) {
    wp_enqueue_style('owl_carousel_styles', get_stylesheet_directory_uri() . '/owl-carousel/owl.carousel.css');
    wp_enqueue_style('owl_theme_styles', get_stylesheet_directory_uri() . '/owl-carousel/owl.theme.css');
  }
}

add_action( 'wp_enqueue_scripts', 'load_stylesheets' );

// Add custom logo
function storefront_display_custom_logo() {
?>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-link" rel="home">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="<?php echo get_bloginfo( 'name' ); ?>" />
    <?php if ( '' != get_bloginfo( 'description' ) ) { ?>
      <p class="site-description"><?php echo bloginfo( 'description' ); ?></p>
    <?php } ?>
  </a>
<?php
}

// Custom secondary navigation for My Account vs Log In
function etc_secondary_navigation() {
  ?>
  <nav class="secondary-navigation" role="navigation" aria-label="Secondary Navigation">
    <div class="partial-refreshable-nav-menu partial-refreshable-nav-menu-1 menu-account-container">
      <ul id="menu-account" class="menu">
        <li id="menu-item-155" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-155">
          <?php if ( is_user_logged_in() ) { ?>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woothemes'); ?>"><?php _e('My Account','woothemes'); ?></a>
          <?php } 
          else { ?>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Log In / Register','woothemes'); ?>"><?php _e('Log In / Register','woothemes'); ?></a>
          <?php } ?>
        </li>
      </ul>
    </div>
  </nav>
<?php }

// Add call to join (called in front-page.php)
function etc_call_to_join() {
?>
  <a href="/membership/join-today"><div id='call-to-join'>Take the plunge and enjoy tons of great benefits. <span>Join Now!</span></div></a>
<?php
}

add_action( 'etc_call_to_join', 'etc_call_to_join');

// Add "Farther. Faster. Together" banner for logged in users
function etc_fft_banner() {
?>
  <div id='fft'>Farther. Faster. Together.</div>
<?php
}

add_action( 'etc_fft_banner', 'etc_fft_banner' );

// Sponsors
function etc_sponsors() { ?>
  <div id='sponsors'>
    <div class='col-full'>
      <h5>Our Partners and Sponsors:</h5>
      <ul id='sponsors-banner'>
        <?php

        $args = array(
          'posts_per_page' => 10,
          'post_type'   => 'etc_sponsors'
        );

        $posts_array = get_posts( $args );

        foreach ( $posts_array as $key => $post ) {

          setup_postdata( $post );
          $post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

          ?>
          <li><a href="<?php echo $post->post_excerpt ?>" target="_blank"><img src='<?php echo $post_thumbnail ?>' alt='<?php echo $post->post_title ?>'/></a></li>

        <?php } ?>
      </ul>
    </div>
  </div>
<?php }

add_action('storefront_before_footer', 'etc_sponsors');

// Register custom post types
function create_post_type() {

  // Blog
  register_post_type( 'etc_blog',
    array(
      'labels'          => array(
        'name'          => __( 'Blog' ),
        'singular_name' => __( 'Blog' )
      ),
      'public'      => true,
      'has_archive' => 'about-the-club/blog',
      'rewrite'     => array('slug' => 'about-the-club/blog')
    )
  );

  // In The News
  register_post_type( 'etc_news',
    array(
      'labels'          => array(
        'name'          => __( 'In The News' ),
        'singular_name' => __( 'In The News' )
      ),
      'public'      => true,
      'has_archive' => 'about-the-club/empire-in-the-news/archive',
      'rewrite'     => array('slug' => 'about-the-club/empire-in-the-news/archive'),
      'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    )
  );

  // Member Discounts
  register_post_type( 'etc_member_discounts',
    array(
      'labels'          => array(
        'name'          => __( 'Member Discounts' ),
        'singular_name' => __( 'Member Discount' )
      ),
      'public'      => true,
      'has_archive' => 'membership/member-discounts',
      'rewrite'     => array('slug' => 'membership/member-discounts'),
      'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    )
  );

  // Sponsors
  register_post_type( 'etc_sponsors',
    array(
      'labels'          => array(
        'name'          => __( 'Sponsors' ),
        'singular_name' => __( 'Sponsor' )
      ),
      'public'      => true,
      'has_archive' => false,
      'rewrite'     => array( 'slug' => 'sponsors' ),
      'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt' )
    )
  );
}
add_action( 'init', 'create_post_type' );


// Set post types per page on news archive
function set_posts_per_page_etc_news( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'etc_news' ) ) {
    $query->set( 'posts_per_page', '10' );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_etc_news' );

// Set post types per page on member discounts page
function set_posts_per_page_etc_member_discounts( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'etc_member_discounts' ) ) {
    $query->set( 'posts_per_page', '-1' );
    $query->set( 'orderby', 'title');
    $query->set( 'order', 'ASC');
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_etc_member_discounts' );

function user_is_empire_member() {
  $user_id = get_current_user_id();
  $this_year = date('Y');
  $seasonal_membership_name = $this_year . '-seasonal-membership';
  $is_annual_member = wc_memberships_is_user_active_member( $user_id, 'empire-tri-membership' );
  $is_seasonal_member = wc_memberships_is_user_active_member( $user_id, $seasonal_membership_name );

  if ( $is_annual_member || $is_seasonal_member ) {
      return true;
  }
}


// Custom Homepage
// Get featured content for the homepage
function empire_homepage_featured() {

  $category_name = user_is_empire_member() ? 'members featured' : 'featured';

  $args = array(
    'category_name'    => $category_name,
    'post_type'   => 'post'
  );

  $posts_array = get_posts( $args );

  foreach ( $posts_array as $key => $post ) {

    setup_postdata( $post );
    $background_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

    ?>

    <div class="carousel-item" style="background-image: url('<?php echo $background_image_url ?>')">
      <div class="carousel-item-content">
      <?php 
        $related_product_url = get_post_meta($post->ID, 'related_product')[0]; 
        $permalink = get_permalink($post->ID);
      ?>

        <a href="<?php echo ($related_product_url) ? $related_product_url : $permalink ?>">
          <h1><?php echo $post->post_title ?></h1>
          <p><?php echo $post->post_excerpt ?></p>
        </a>
      </div>
      <div id='gradient'></div>
    </div>

<?php

  }

  wp_reset_postdata();

}

add_action( 'empire_homepage_featured', 'empire_homepage_featured');

// Homepage 'buckets'

function empire_homepage_buckets() {

  ?>

  <ul class='products'>

  <?php

  $category_name = user_is_empire_member() ? 'members buckets' : 'buckets';

  $args = array(
    'category_name'    => $category_name,
    'post_type'   => 'post'
  );

  $posts_array = get_posts( $args );

  foreach ( $posts_array as $key => $post ) {

    setup_postdata( $post );
    $post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

    ?>

    <li class="product">
      <div class="bucket">
        <div class="bucket-image" style="background-image: url('<?php echo $post_thumbnail ?>')"></div>
        <h1><?php echo $post->post_title ?></h1>
        <?php the_content() ?>
      <div>
    </li>

  <?php } ?>

  </ul>

  <?php wp_reset_postdata();

}
add_action( 'empire_homepage_buckets', 'empire_homepage_buckets' );

// Empire copyright
function etc_credit() {
  ?>
  <div class="site-info">
    <?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) ); ?>
  </div><!-- .site-info -->
  <?php
}

// Color Palette Override
function dmw_custom_palette( $init ) {
  $default_colors = '
      "000000", "Black",
      "993300", "Burnt orange",
      "333300", "Dark olive",
      "003300", "Dark green",
      "003366", "Dark azure",
      "000080", "Navy Blue",
      "333399", "Indigo",
      "333333", "Very dark gray",
      "800000", "Maroon",
      "FF6600", "Orange",
      "808000", "Olive",
      "008000", "Green",
      "008080", "Teal",
      "0000FF", "Blue",
      "666699", "Grayish blue",
      "808080", "Gray",
      "FF0000", "Red",
      "FF9900", "Amber",
      "99CC00", "Yellow green",
      "339966", "Sea green",
      "33CCCC", "Turquoise",
      "3366FF", "Royal blue",
      "800080", "Purple",
      "999999", "Medium gray",
      "FF00FF", "Magenta",
      "FFCC00", "Gold",
      "FFFF00", "Yellow",
      "00FF00", "Lime",
      "00FFFF", "Aqua",
      "00CCFF", "Sky blue",
      "993366", "Brown",
      "C0C0C0", "Silver",
      "FF99CC", "Pink",
      "FFCC99", "Peach",
      "FFFF99", "Light yellow",
      "CCFFCC", "Pale green",
      "CCFFFF", "Pale cyan",
      "99CCFF", "Light sky blue",
      "CC99FF", "Plum",
      "FFFFFF", "White"
      ';
  $custom_colors = '
    "626367", "Empire Gray",
    "B71234", "Empire Red",
    "B6BF00", "Empire Green",
    "0154A0", "Empire Dark Blue",
    "0098DB", "Empire Ligh Blue",
    "6F2586", "Empire Purple",
    "CF8E00", "Empire Gold" ';
  $init['textcolor_map'] = '['.$default_colors.','.$custom_colors.']';
  $init['textcolor_rows'] = 6; // expand colour grid to 6 rows

  return $init;
}
add_filter('tiny_mce_before_init', 'dmw_custom_palette');












/**
 * Add new register fields for WooCommerce registration.
 *
 * @return string Register fields HTML.
 */
function wooc_extra_register_fields() {
  ?>

  <p class="form-row form-row-first">
  <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
  <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
  </p>

  <p class="form-row form-row-last">
  <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
  <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
  </p>

  <?php
}

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

/**
 * Save the extra register fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
function wooc_save_extra_register_fields( $customer_id ) {
  if ( isset( $_POST['billing_first_name'] ) ) {
    // WordPress default first name field.
    update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

    // WooCommerce billing first name.
    update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
  }

  if ( isset( $_POST['billing_last_name'] ) ) {
    // WordPress default last name field.
    update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

    // WooCommerce billing last name.
    update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
  }

}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

function add_googleanalytics() { ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-74119756-1', 'auto');
      ga('send', 'pageview');

    </script>
<?php }

add_action('wp_footer', 'add_googleanalytics');

 function add_fbpixel() { ?>
    <script>
      !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
      n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
      document,'script','//connect.facebook.net/en_US/fbevents.js');
  
      fbq('init', '877432389042573');
      fbq('track', "PageView");
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=877432389042573&ev=PageView&noscript=1"
    /></noscript>
 <?php }
 
 add_action('wp_head', 'add_fbpixel');
 
 //remove crazy person password strength check for new passwords
function wc_ninja_remove_password_strength() {
    if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
        wp_dequeue_script( 'wc-password-strength-meter' );
    }
}

add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );
