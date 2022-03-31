<aside class="speakers__sidebar">
  <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter" class="speakers__form">
    <legend>Positions</legend>
    <div>
    <?php
      if( $positions = get_terms( array( 'taxonomy' => 'positions' ) ) ) :
        foreach( $positions as $position ) :
          echo '
            <div>
              <input type="checkbox" id="position_' . $position->term_id . '" name="position_' . $position->term_id . '" />
              <label for="position_' . $position->term_id . '">' . $position->name . '</label>
            </div>
          ';
        endforeach;
      endif;
    ?>
    </div>
    <legend>Countries</legend>
    <div>
    <?php
      if( $countries = get_terms( array( 'taxonomy' => 'countries' ) ) ) :
        foreach( $countries as $country ) :
          echo '
            <div>
              <input type="checkbox" id="country_' . $country->term_id . '" name="country_' . $country->term_id . '" />
              <label for="country_' . $country->term_id . '">' . $country->name . '</label>
            </div>
          ';
        endforeach;
      endif;
    ?>
    </div>
    <input type="hidden" name="action" value="myfilter">
  </form>

</aside>
<!-- /.aside -->