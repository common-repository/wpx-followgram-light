<h2>Appearance</h2>

<p>
  <label for="<?php echo $widget->get_field_name( 'title' ) ?>">Title:</label>
  <input type="text"
         class="widefat"
         id="<?php echo $widget->get_field_name( 'title' ) ?>"
         name="<?php echo $widget->get_field_name( 'title' ) ?>"
         placeholder="Title in fromtend"
         value="<?php echo $instance[ 'title' ] ?>"/>
</p>

<p>
  <label for="<?php echo $widget->get_field_name( 'photo_number' ) ?>">Photo number:</label>
  <input type="number"
         class="tiny-text"
         step="1"
         min="4"
         max="16"
         id="<?php echo $widget->get_field_name( 'photo_number' ) ?>"
         name="<?php echo $widget->get_field_name( 'photo_number' ) ?>"
         value="<?php echo $instance[ 'photo_number' ] ?>"/>

  <label for="<?php echo $widget->get_field_name( 'size' ) ?>">Size:</label>
  <select id="<?php echo $widget->get_field_name( 'size' ) ?>"
          name="<?php echo $widget->get_field_name( 'size' ) ?>">
    <option value="small" <?php selected( 'small', $instance[ 'size' ] ) ?>>Small</option>
    <option value="medium" <?php selected( 'medium', $instance[ 'size' ] ) ?>>Medium</option>
    <option value="large" <?php selected( 'large', $instance[ 'size' ] ) ?>>Large</option>
  </select>
</p>

<p>
  <label for="<?php echo $widget->get_field_name( 'theme' ) ?>">Theme:</label>
  <select id="<?php echo $widget->get_field_name( 'theme' ) ?>"
          name="<?php echo $widget->get_field_name( 'theme' ) ?>">
    <option <?php selected( 'wpxfollowgram-widget-default.min.css', $instance[ 'theme' ] ) ?>
      value="wpxfollowgram-widget-default.min.css">Default
    </option>
    <option <?php selected( 'wpxfollowgram-widget-darkness.min.css', $instance[ 'theme' ] ) ?>
      value="wpxfollowgram-widget-darkness.min.css">Darkness
    </option>
  </select>
</p>

<h2>Advance cache</h2>

<p>
  <label for="<?php echo $widget->get_field_name( 'enabled_cache' ) ?>">Enable cache:</label>
  <input type="checkbox"
         id="<?php echo $widget->get_field_name( 'enabled_cache' ) ?>"
         name="<?php echo $widget->get_field_name( 'enabled_cache' ) ?>"
         <?php checked( "on", $instance[ 'enabled_cache' ] ) ?>
         value="on"/>

  <label for="<?php echo $widget->get_field_name( 'cacheduration' ) ?>">Duration:</label>
  <select id="<?php echo $widget->get_field_name( 'cacheduration' ) ?>"
          name="<?php echo $widget->get_field_name( 'cacheduration' ) ?>">
    <option <?php selected( '900', $instance[ 'cacheduration' ] ) ?> value="900">15 minutes</option>
    <option <?php selected( '1800', $instance[ 'cacheduration' ] ) ?> value="1800">30 minutes</option>
    <option <?php selected( '3600', $instance[ 'cacheduration' ] ) ?> value="3600">1 hour</option>
    <option <?php selected( '21600', $instance[ 'cacheduration' ] ) ?> value="21600">6 hours</option>
  </select>
</p>
