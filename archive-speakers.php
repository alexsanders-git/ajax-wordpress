<?php get_header(); ?>

<section class="speakers">
  <div class="container container--small">
    <h2 class="speakers__title">Speakers</h2>
    <div class="speakers__wrapper">
      <?php get_sidebar(); ?>

      <div class="speakers__list">

      <?php		
        global $post;

        $query = new WP_Query( [
          'posts_per_page' => 3,
          'post_type'      => 'speakers',
          'paged'          => 1
        ] );

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

        wp_reset_postdata(); // Сбрасываем $post
      ?>
      </div>
    </div>
    <?php
        global $wp_query;

        // текущая страница
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        // максимум страниц
        $max_pages = $wp_query->max_num_pages;
        
        // если текущая страница меньше, чем максимум страниц, то выводим кнопку
        if( $paged < $max_pages ) {
          echo '
          <div id="loadmore" class="speakers__button">
            <button data-max_pages="' . $max_pages . '" data-paged="' . $paged . '" class="button button--arrow">Load more</button>
          </div>
          ';
        }
    ?>
  </div>
</section>
<!-- /.speakers -->

<?php get_footer(); ?>