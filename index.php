<?php

/**
 * Plugin Name: WPX Followgram Light
 * Plugin URI: http://undolog.com
 * Description: Simple sidebar widget that shows Your Instagram profile with 8 instagr.am pictures, follower, following and photos.
 * Version: 2.1.0
 * Author: Giovambattista Fazioli
 * Author URI: http://undolog.com
 * Text Domain: wpx-followgram-light
 * Domain Path: localization
 *
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/
use WPXFollowgramLight\WPBones\Foundation\Plugin;

require_once __DIR__ . '/bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap the plugin
|--------------------------------------------------------------------------
|
| We need to bootstrap the plugin.
|
*/

$GLOBALS[ 'WPXFollowgramLight' ] = require_once __DIR__ . '/bootstrap/plugin.php';

if (! function_exists('WPXFollowgramLight')) {

  /**
   * Return the instance of plugin.
   *
   * @return Plugin
   */
    function WPXFollowgramLight()
    {
        return $GLOBALS[ 'WPXFollowgramLight' ];
    }
}
