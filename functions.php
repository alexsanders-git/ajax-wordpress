<?php

define('MY_THEME_ROOT', get_template_directory_uri());
define('MY_CSS_DIR', MY_THEME_ROOT . '/css');
define('MY_JS_DIR', MY_THEME_ROOT . '/js');
define('MY_IMG_DIR', MY_THEME_ROOT . '/img');

// AJAX Load More
add_action( 'wp_enqueue_scripts', 'my_assets' );

function my_assets() {
  wp_enqueue_script( 'filter',  MY_JS_DIR . '/filter.js', array('jquery') );
  wp_enqueue_script( 'loadmore',  MY_JS_DIR . '/loadmore.js', array('jquery') );
	
	wp_localize_script( 'loadmore', 'myAjax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	) );
}

add_action( 'wp_ajax_loadmore', 'my_loadmore' );
add_action( 'wp_ajax_nopriv_loadmore', 'my_loadmore' );

function my_loadmore() {
  $paged = ! empty( $_POST[ 'paged' ] ) ? $_POST[ 'paged' ] : 1;
	$paged++;

	$args = array(
		'paged' => $paged,
		'post_type' => 'speakers',
    // 'posts_per_page' => -1,
	);

  $query = new WP_Query( $args );
  
  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      ?>
      <div class="speakers__item">
        <div class="speakers__country">
          <?php $countries = get_the_terms($post->ID, 'countries'); ?>
          <img src="<?php echo get_template_directory_uri(); ?>/image/speakers/countryball-<?php foreach($countries as $country) {echo $country->slug;} ?>.svg" alt="<?php foreach($countries as $country) {echo $country->slug;} ?>">
        </div>
        <div class="speakers__photo">
          <?php the_post_thumbnail(); ?>
        </div>
        <a href="<?php echo get_the_permalink(); ?>" class="speakers__name"><?php the_title(); ?></a>
        <div class="speakers__positions">
          <?php the_terms($post->ID, 'positions'); ?>
        </div>
      </div>
      <?php 
    }
  } else {
    ?>
    <p>No posts found</p>
    <?php
  }
  wp_die();
}

// AJAX Filter
function mysite_filter_function(){

  //positions checkboxes
  if( $positions = get_terms( array( 'taxonomy' => 'positions' ) ) ) :
  $positions_terms = array();
  
  foreach( $positions as $position ) {
    if( isset( $_POST['position_' . $position->term_id ] ) && $_POST['position_' . $position->term_id] == 'on' )
      $positions_terms[] = $position->slug;
  }
  endif;
  
  //countries checkboxes
  if( $countries = get_terms( array( 'taxonomy' => 'countries' ) ) ) :
  $countries_terms = array();
  
  foreach( $countries as $country ) {
    if( isset( $_POST['country_' . $country->term_id ] ) && $_POST['country_' . $country->term_id] == 'on' )
      $countries_terms[] = $country->slug;
  }
  endif;
  
  $tax_query = array( 'relation' => 'AND' );

  if ( ! empty( $positions_terms ) ) {
    $tax_query[] = array(
      'taxonomy' => 'positions',
      'field'    => 'slug',
      'terms'    => $positions_terms,
    );
  }

  if ( ! empty( $countries_terms ) ) {
    $tax_query[] = array(
      'taxonomy' => 'countries',
      'field'    => 'slug',
      'terms'    => $countries_terms,
    );
  }

  $args = array(
    'orderby'        => 'date',
    'post_type'      => 'speakers',
    // 'posts_per_page' => -1,
    'tax_query'      => $tax_query,
  );
  
  $query = new WP_Query( $args );
  
  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      ?>
      <div class="speakers__item">
        <div class="speakers__country">
          <?php $countries = get_the_terms($post->ID, 'countries'); ?>
          <img src="<?php echo get_template_directory_uri(); ?>/image/speakers/countryball-<?php foreach($countries as $country) {echo $country->slug;} ?>.svg" alt="<?php foreach($countries as $country) {echo $country->slug;} ?>">
        </div>
        <div class="speakers__photo">
          <?php the_post_thumbnail(); ?>
        </div>
        <a href="<?php echo get_the_permalink(); ?>" class="speakers__name"><?php the_title(); ?></a>
        <div class="speakers__positions">
          <?php the_terms($post->ID, 'positions'); ?>
        </div>
      </div>
      <?php 
    }
  } else {
    ?>
    <p>No posts found</p>
    <?php
  }
  wp_die();
  }


  add_action('wp_ajax_myfilter', 'mysite_filter_function');
  add_action('wp_ajax_nopriv_myfilter', 'mysite_filter_function');

?>