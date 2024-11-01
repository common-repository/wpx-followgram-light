<?php

namespace WPXFollowgramLight\WPBones\Contracts\Foundation;

use WPXFollowgramLight\WPBones\Contracts\Container\Container;

interface Plugin extends Container {

  /**
   * Get the base path of the Plugin installation.
   *
   * @return string
   */
  public function getBasePath();
}