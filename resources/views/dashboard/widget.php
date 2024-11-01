<!--
 |
 | In $plugin you'll find an instance of Plugin class.
 | If you'd like can pass variable to this view, for example:
 |
 | return PluginClassName()->view( 'dashboard.index', [ 'var' => 'value' ] );
 |
-->

<div id="wpxfollowgram-intro" class="wpx-followgram-light wrap">
  <h1>Followgram</h1>

  <h2>Widget instruction</h2>

  <p>
    In order to display your instragram images, go to <a
      href="<?php echo admin_url('widgets.php') ?>">Widgets</a>
    menu
    and settings the <strong>Followgram</strong> widgets properties like shows below.
  </p>

  <div class="aligncenter">
    <p>
      <img
        alt="<?php _e('Settings Widgets', 'wpx-followgram-light') ?>"
        src="<?php echo $plugin->images . '/screenshot-1.png' ?>" />

    </p>
    <strong>
      <?php _e('Settings Widgets', 'wpx-followgram-light') ?>
    </strong>

    <p class="cent">
      <img
        alt="<?php _e('Choose your theme', 'wpx-followgram-light') ?>"
        src="<?php echo $plugin->images . '/screenshot-2.png' ?>" />
    </p>
    <strong>
      <?php _e('Choose your theme', 'wpx-followgram-light') ?>
    </strong>
  </div>

</div>