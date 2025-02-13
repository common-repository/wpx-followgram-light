<?php

namespace WPXFollowgramLight\WPBones\Foundation;

use WPXFollowgramLight\WPBones\Support\ServiceProvider;
use WPXFollowgramLight\WPBones\Foundation\Http\Request;

abstract class WordPressAjaxServiceProvider extends ServiceProvider {

  /**
   * List of the ajax actions executed by both logged and not logged users.
   * Here you will used a methods list.
   *
   * @var array
   */
  protected $trusted = [ ];

  /**
   * List of the ajax actions executed only by logged in users.
   * Here you will used a methods list.
   *
   * @var array
   */
  protected $logged = [ ];

  /**
   * List of the ajax actions executed only by not logged in user, usually from frontend.
   * Here you will used a methods list.
   *
   * @var array
   */
  protected $notLogged = [ ];

  private $_request = null;

  /**
   * Init the registred Ajax cactions.
   *
   */
  public function register()
  {
    foreach ( $this->notLogged as $action ) {
      add_action( 'wp_ajax_nopriv_' . $action, [ $this, $action ] );
    }

    foreach ( $this->trusted as $action ) {
      add_action( 'wp_ajax_nopriv_' . $action, [ $this, $action ] );
      add_action( 'wp_ajax_' . $action, [ $this, $action ] );
    }

    foreach ( $this->logged as $action ) {
      add_action( 'wp_ajax_' . $action, [ $this, $action ] );
    }
  }

  public function getRequestAttribute()
  {
    if ( is_null( $this->_request ) ) {
      $this->_request = new Request();
    }

    return $this->_request;
  }

  public function __get( $name )
  {
    $method = 'get' . ucfirst( $name ) . 'Attribute';
    if ( method_exists( $this, $method ) ) {
      return $this->$method();
    }
  }
}