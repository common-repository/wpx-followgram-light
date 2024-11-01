<?php

namespace WPXFollowgramLight\WPBones\Foundation;

use WPXFollowgramLight\WPBones\Container\Container;
use WPXFollowgramLight\WPBones\Database\WordPressOption;
use WPXFollowgramLight\WPBones\View\View;
use WPXFollowgramLight\WPBones\Contracts\Foundation\Plugin as PluginContract;
use WPXFollowgramLight\WPBones\Foundation\Http\Request;

class Plugin extends Container implements PluginContract
{

  /**
   * The Bones framework version.
   *
   * @var string
   */
  const VERSION = '0.2.0';

  /**
   * The current globally available container (if any).
   *
   * @var static
   */
  protected static $instance;

  /**
   * Buld in __FILE__ relative plugin.
   *
   * @var string
   */
  protected $file;

  /**
   * The base path for the plugin installation.
   *
   * @var string
   */
  protected $basePath;

  /**
   * The base uri for the plugin installation.
   *
   * @var string
   */
  protected $baseUri;

  /**
   * The base uri for the public images.
   *
   * @var string
   */
  protected $publicImagesUri;

  /**
   * The base uri for the public css.
   *
   * @var string
   */
  protected $publicCssUri;

  /**
   * the base uri for the public js.
   *
   * @var string
   */
  protected $publicJsUri;

  /**
   * Internal use where store the plugin data.
   *
   * @var array
   */
  protected $pluginData = [ ];

  /**
   * A key value pairs array with the list of providers.
   *
   * @var array
   */
  protected $provides = [];

  private $_options = null;

  private $_request = null;

  /**
   * The slug of this plugin.
   *
   * @var string
   */
  public $slug = "";

  public function __construct( $basePath )
  {
    $this->basePath = rtrim( $basePath, '\/' );

    $this->boot();
  }

  public function __get( $name )
  {
    $method = 'get' . ucfirst( $name ) . 'Attribute';
    if ( method_exists( $this, $method ) ) {
      return $this->$method();
    }

    foreach ( $this->pluginData as $key => $value ) {
      if ( $name == $key ) {
        return $value;
      }
    }
  }

  public function boot()
  {
    // emule __FILE__
    $this->file = $this->basePath . '/index.php';

    $this->baseUri = rtrim( plugin_dir_url( $this->file ), '\/' );

    $this->publicImagesUri = $this->baseUri . '/public/images';
    $this->publicCssUri    = $this->baseUri . '/public/css';
    $this->publicJsUri     = $this->baseUri . '/public/js';

    // Use WordPress get_plugin_data() function for auto retrive plugin information.
    if ( ! function_exists( 'get_plugin_data' ) ) {
      require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    $this->pluginData = get_plugin_data( $this->file, false );

    /*
     * In $this->pluginData you'll find all WordPress
     *
      Author = "Giovambattista Fazioli"
      AuthorName = "Giovambattista Fazioli"
      AuthorURI = "http://undolog.com"
      Description = "WPX Followgram Light is a WP Bones boilperate plugin"
      DomainPath = "localization"
      Name = "WPX Followgram Light"
      Network = false
      PluginURI = "http://undolog.com"
      TextDomain = "wpx-followgram-light"
      Title = "WPX Followgram Light"
      Version = "1.0.0"
    
     */

    // plugin slug
    $this->slug = str_replace( "-", "_", sanitize_title( $this->Name ) ) . "_slug";

    // Load text domain
    load_plugin_textdomain( "wpx-followgram-light", false, trailingslashit( basename( $this->basePath ) ) . $this->DomainPath );

    // Activation & Deactivation Hook
    register_activation_hook( $this->file, [ $this, 'activation' ] );
    register_deactivation_hook( $this->file, [ $this, 'deactivation' ] );

    /*
     * There are many pitfalls to using the uninstall hook. It ’ s a much cleaner, and easier, process to use the
     * uninstall.php method for removing plugin settings and options when a plugin is deleted in WordPress.
     *
     * Using uninstall.php file. This is typically the preferred method because it keeps all your uninstall code in a
     * separate file. To use this method, create an uninstall.php file and place it in the root directory of your
     * plugin. If this file exists WordPress executes its contents when the plugin is deleted from the WordPress
     * Plugins screen page.
     *
     */

    // register_uninstall_hook( $file, array( $this, 'uninstall' ) );

    // Fires after WordPress has finished loading but before any headers are sent.
    add_action( 'init', array( $this, 'init' ) );

    // Fires before the administration menu loads in the admin.
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );

    // Fires after all default WordPress widgets have been registered.
    add_action( 'widgets_init', [ $this, 'widgets_init' ] );

    // Filter a screen option value before it is set.
    add_filter( 'set-screen-option', [ $this, 'set_screen_option' ], 10, 3 );

    static::$instance = $this;

    return $this;

  }

  public function set_screen_option( $status, $option, $value )
  {
    if ( in_array( $option, array_keys( $this->config( 'plugin.screen_options', [ ] ) ) ) ) {
      return $value;
    }

    return $status;
  }

  public function getOptionsAttribute()
  {
    if ( is_null( $this->_options ) ) {
      $this->_options = new WordPressOption( $this );
    }

    return $this->_options;
  }

  public function getRequestAttribute()
  {
    if ( is_null( $this->_request ) ) {
      $this->_request = new Request();
    }

    return $this->_request;
  }


  /**
   * Get the version number of the plugin.
   *
   * @return string
   */
  public function getVersion()
  {
    return static::VERSION;
  }

  /**
   * Get the base path of the plugin installation.
   *
   * @return string
   */
  public function getBasePath()
  {
    return $this->basePath;
  }

  /**
   * Return the absolute URL for the installation plugin.
   *
   * @return string
   */
  public function getBaseUri()
  {
    return $this->baseUri;
  }

  /**
   * Return the absolute URL for the public images.
   *
   * @return string
   */
  public function getPublicImagesUri()
  {
    return $this->publicImagesUri;
  }

  /**
   * Return the absolute URL for the public images.
   *
   * @return string
   */
  public function getPublicCssUri()
  {
    return $this->publicCssUri;
  }

  /**
   * Return the absolute URL for the public scripts.
   *
   * @return string
   */
  public function getPublicJsUri()
  {
    return $this->publicJsUri;
  }

  /**
   * Get / set the specified configuration value.
   *
   * If an array is passed as the key, we will assume you want to set an array of values.
   *
   * @param  array|string $key
   * @param  mixed        $default
   *
   * @return mixed
   */
  public function config( $key = null, $default = null )
  {
    if ( is_null( $key ) ) {
      return [ ];
    }

    $parts = explode( ".", $key );

    $filename = $parts[ 0 ] . ".php";
    $key      = isset( $parts[ 1 ] ) ? $parts[ 1 ] : null;

    $array = include $this->basePath . '/config/' . $filename;

    if ( is_null( $key ) ) {
      return $array;
    }

    if ( isset( $array[ $key ] ) ) {
      return $array[ $key ];
    }

    unset( $parts[ 0 ] );

    foreach ( $parts as $segment ) {
      if ( ! is_array( $array ) || ! array_key_exists( $segment, $array ) ) {
        return wpbones_value( $default );
      }

      $array = $array[ $segment ];
    }

    return $array;
  }

  /**
   * Gets the value of an environment variable. Supports boolean, empty and null.
   *
   * @param  string $key
   * @param  mixed  $default
   *
   * @return mixed
   */
  public function env( $key, $default = null )
  {
    return wpbones_env( $key, $default );
  }

  /**
   * Return an instance of View/Contract.
   *
   * @param null $key  Optional. Default null.
   * @param null $data Optional. Default null.
   *
   * @return \WPXFollowgramLight\WPBones\View\View
   */
  public function view( $key = null, $data = null )
  {

    $view = new View( $this, $key, $data );

    return $view;

  }

  /**
   * Return TRUE if an Ajax called
   *
   * @return bool
   */
  public function isAjax()
  {
    if ( defined( 'DOING_AJAX' ) ) {
      return true;
    }
    if ( isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) &&
         strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) == 'xmlhttprequest'
    ) {
      return true;
    }

    return false;
  }

  public function getPageUrl( $pageSlug )
  {
    return add_query_arg( array( 'page' => $pageSlug ), admin_url( 'admin.php' ) );
  }

  public function provider( $name ) {

    foreach( $this->provides as $key => $value ) {

      if( $key == $name ) {
        return $value;
      }
    }

    return null;
  }

  /*
  |--------------------------------------------------------------------------
  | WordPress actions & filter
  |--------------------------------------------------------------------------
  |
  | When a plugin starts we will use some useful actions and filters.
  |
  */

  /**
   * Called when a plugin is activate; `register_activation_hook()`
   *
   */
  public function activation()
  {
    $this->options->delta();

    // include your own activation
    $activation = include_once $this->basePath . '/plugin/activation.php';

    // migrations
    foreach ( glob( $this->basePath . '/database/migrations/*.php' ) as $filename ) {
      include $filename;
      foreach ( $this->getFileClasses( $filename ) as $className ) {
        $instance = new $className;
      }
    }
  }

  /**
   * Called when a plugin is deactivate; `register_deactivation_hook()`
   *
   */
  public function deactivation()
  {
    $deactivation = include_once $this->basePath . '/plugin/deactivation.php';
  }

  /**
   * Fires after WordPress has finished loading but before any headers are sent.
   *
   * Most of WP is loaded at this stage, and the user is authenticated. WP continues
   * to load on the init hook that follows (e.g. widgets), and many plugins instantiate
   * themselves on it for all sorts of reasons (e.g. they need a user, a taxonomy, etc.).
   *
   * If you wish to plug an action once WP is loaded, use the wp_loaded hook below.
   *
   * @since 1.5.0
   */
  public function init()
  {
    $init = include_once $this->basePath . '/config/plugin.php';

    if ( is_array( $init ) ) {

      // Here we are going to init Service Providers

      // Custom post types Service Provider
      if ( isset( $init[ 'custom_post_types' ] ) && ! empty( $init[ 'custom_post_types' ] ) ) {
        foreach ( $init[ 'custom_post_types' ] as $className ) {
          $object = new $className;
          $object->register();
          $this->provides[$className] = $object;
        }
      }

      // Custom taxonomy type Service Provider
      if ( isset( $init[ 'custom_taxonomy_types' ] ) && ! empty( $init[ 'custom_taxonomy_types' ] ) ) {
        foreach ( $init[ 'custom_taxonomy_types' ] as $className ) {
          $object = new $className;
          $object->register();
          $this->provides[$className] = $object;
        }
      }

      // Shortcodes Service Provider
      if ( isset( $init[ 'shortcodes' ] ) && ! empty( $init[ 'shortcodes' ] ) ) {
        foreach ( $init[ 'shortcodes' ] as $className ) {
          $object = new $className;
          $object->register();
          $this->provides[$className] = $object;
        }
      }

      // Ajax Service Provider
      if ( $this->isAjax() ) {
        if ( isset( $init[ 'ajax' ] ) && ! empty( $init[ 'ajax' ] ) ) {
          foreach ( $init[ 'ajax' ] as $className ) {
            $object = new $className;
            $object->register();
            $this->provides[$className] = $object;
          }
        }
      }

      // Custom service provider
      if ( isset( $init[ 'providers' ] ) && ! empty( $init[ 'providers' ] ) ) {
        foreach ( $init[ 'providers' ] as $className ) {
          $object = new $className;
          $object->register();
          $this->provides[$className] = $object;
        }
      }
    }
  }

  /**
   * Fires before the administration menu loads in the admin.
   */

  public function admin_menu()
  {
    global $admin_page_hooks, $_registered_pages, $_parent_pages;

    $menus = include_once $this->basePath . '/config/menus.php';

    if ( ! empty( $menus ) && is_array( $menus ) ) {

      foreach ( $menus as $topLevelSlug => $menu ) {

        // TODO sanitize array keys
        $menu[ 'position' ]   = isset( $menu[ 'position' ] ) ? $menu[ 'position' ] : null;
        $menu[ 'capability' ] = isset( $menu[ 'capability' ] ) ? $menu[ 'capability' ] : 'read';

        // icon
        $icon = '';
        if ( isset( $menu[ 'icon' ] ) && ! empty( $menu[ 'icon' ] ) ) {
          $icon = $this->publicImagesUri . '/' . $menu[ 'icon' ];
        }

        add_menu_page( $menu[ 'page_title' ], $menu[ 'menu_title' ], $menu[ 'capability' ], $topLevelSlug, '', $icon, $menu[ 'position' ] );

        foreach ( $menu[ 'items' ] as $subMenu ) {

          $submenuSlug = isset( $submenuSlug ) ? sanitize_key( $subMenu[ 'page_title' ] ) : $topLevelSlug;

          // TODO sanitize array keys
          $subMenu[ 'capability' ] = isset( $subMenu[ 'capability' ] ) ? $subMenu[ 'capability' ] : 'read';

          // get hook
          $hook = $this->getCallableHook( $subMenu[ 'route' ] );

          $subMenuHook = add_submenu_page( $topLevelSlug, $subMenu[ 'page_title' ], $subMenu[ 'menu_title' ], $subMenu[ 'capability' ], $submenuSlug, $hook );

          if ( isset( $subMenu[ 'route' ][ 'load' ] ) ) {
            list( $controller, $method ) = explode( '@', $subMenu[ 'route' ][ 'load' ] );

            $func = create_function( '', sprintf( '$instance = new %s; return $instance->%s();',
                                                  'WPXFollowgramLight\\Http\\Controllers\\' . $controller, $method ) );
            add_action( "load-{$subMenuHook}", $func );
          }

          add_action( "load-{$subMenuHook}", [ $this, 'load_submenu' ] );

        }
      }
    }

    // custom hidden pages
    $pages = include_once $this->basePath . '/config/routes.php';

    if ( ! empty( $pages ) && is_array( $pages ) ) {
      foreach ( $pages as $pageSlug => $page ) {

        $pageSlug                      = plugin_basename( $pageSlug );
        $admin_page_hooks[ $pageSlug ] = ! isset( $page[ 'title' ] ) ? : $page[ 'title' ];
        $hookName                      = get_plugin_page_hookname( $pageSlug, '' );

        if ( ! empty( $hookName ) ) {

          add_action( $hookName, $this->getCallableHook( $page[ 'route' ] ) );

          $_registered_pages[ $hookName ] = true;
          $_parent_pages[ $pageSlug ]     = false;
        }
      }
    }
  }

  public function widgets_init()
  {
    global $wp_widget_factory;

    $widgets = include_once $this->basePath . '/config/widgets.php';

    if ( is_array( $widgets ) && ! empty( $widgets ) ) {
      foreach ( $widgets as $className ) {
        //register_widget( $className );
        $wp_widget_factory->widgets[ $className ] = new $className( $this );
      }
    }
  }

  public function load_submenu()
  {
    $screen_options = $this->config( 'plugin.screen_options', [ ] );

    // screen options
    if ( ! empty( $screen_options ) ) {
      foreach ( $screen_options as $key => $value ) {
        if ( is_string( $value ) ) {

          $args = [
            'label'   => 'Items number',
            'default' => 5,
            'option'  => $key
          ];
        }
        //
        elseif ( is_array( $value ) ) {
          $args = [
            'label'   => isset( $value[ 'label' ] ) ? $value[ 'label' ] : 'Items number',
            'default' => isset( $value[ 'default' ] ) ? $value[ 'default' ] : 5,
            'option'  => $key
          ];

        }

        $func = create_function( '$a',
                                 sprintf(
                                   'add_screen_option( \'per_page\', $a ); global $%s; $%s = new %s();',
                                   sanitize_title( $value ),
                                   sanitize_title( $value ),
                                   $value )
        );

        $func( $args );
      }
    }

  }

  // -- private

  private function getCallableHook( $routes )
  {
    // get the http request verb
    $verb = $this->request->method;

    if ( isset( $routes[ 'resource' ] ) ) {
      $methods = [
        'get'    => 'index',
        'post'   => 'store',
        'put'    => 'update',
        'patch'  => 'update',
        'delete' => 'destroy',
      ];

      $controller = $routes[ 'resource' ];
      $method     = $methods[ $verb ];
    }
    // by single verb and controller@method
    else {

      if ( isset( $routes[ $verb ] ) ) {
        list( $controller, $method ) = explode( '@', $routes[ $verb ] );
      }
      // default "get"
      else {
        list( $controller, $method ) = explode( '@', $routes[ 'get' ] );
      }
    }

    $hook = create_function( '', sprintf( '$instance = new %s; return( $instance->render( "%s" ) );',
                                          'WPXFollowgramLight\\Http\\Controllers\\' . $controller, $method ) );

    return $hook;
  }

  /**
   * Return the list of classes in a PHP file.
   *
   * @param string $filename A PHP Filename file.
   *
   * @return array|bool
   */
  private function getFileClasses( $filename )
  {
    $code = file_get_contents( $filename );

    if ( empty( $code ) ) {
      return false;
    }

    $classes = array();
    $tokens  = token_get_all( $code );
    $count   = count( $tokens );
    for ( $i = 2; $i < $count; $i++ ) {
      if ( $tokens[ $i - 2 ][ 0 ] == T_CLASS
           && $tokens[ $i - 1 ][ 0 ] == T_WHITESPACE
           && $tokens[ $i ][ 0 ] == T_STRING
      ) {

        $class_name = $tokens[ $i ][ 1 ];
        $classes[]  = $class_name;
      }
    }

    return $classes;

  }

}