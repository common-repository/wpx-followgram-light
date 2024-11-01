<?php

namespace WPXFollowgramLight\WPBones\Foundation;

use WPXFollowgramLight\WPBones\Support\ServiceProvider;

abstract class WordPressShortcodesServiceProvider extends ServiceProvider {

  /**
   * List of registered shortcodes. Here you will used a methods list.
   *
   * @var array
   */
  protected $shortcodes = [ ];

  /**
   * Init the registred shortcodes.
   *
   */
  public function register()
  {
    foreach ( $this->shortcodes as $shortcode => $method ) {
      add_shortcode( $shortcode, array( $this, $method ) );
    }
  }
}