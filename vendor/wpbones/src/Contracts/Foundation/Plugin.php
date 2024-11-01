<?php

namespace WPXFollowgramLight\WPBones\Contracts\Foundation;

use WPXFollowgramLight\WPBones\Contracts\Container\Container;

interface Plugin extends Container {

  /**
   * Get the version number of the application.
   *
   * @return string
   */
  public function getVersion();

  /**
   * Get the base path of the Laravel installation.
   *
   * @return string
   */
  public function getBasePath();
}