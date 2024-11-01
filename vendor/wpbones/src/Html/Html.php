<?php

namespace WPXFollowgramLight\WPBones\Html;

class Html
{

  protected static $htmlTags = [
    'a'        => '\WPXFollowgramLight\WPBones\Html\HtmlTagA',
    'button'   => '\WPXFollowgramLight\WPBones\Html\HtmlTagButton',
    'checkbox' => '\WPXFollowgramLight\WPBones\Html\HtmlTagCheckbox',
    'fieldset' => '\WPXFollowgramLight\WPBones\Html\HtmlTagFieldSet',
    'form'     => '\WPXFollowgramLight\WPBones\Html\HtmlTagForm',
    'input'    => '\WPXFollowgramLight\WPBones\Html\HtmlTagInput',
    'label'    => '\WPXFollowgramLight\WPBones\Html\HtmlTagLabel',
    'optgroup' => '\WPXFollowgramLight\WPBones\Html\HtmlTagOptGroup',
    'option'   => '\WPXFollowgramLight\WPBones\Html\HtmlTagOption',
    'select'   => '\WPXFollowgramLight\WPBones\Html\HtmlTagSelect',
    'textarea' => '\WPXFollowgramLight\WPBones\Html\HtmlTagTextArea',
  ];

  public static function __callStatic( $name, $arguments )
  {
    if ( in_array( $name, array_keys( self::$htmlTags ) ) ) {
      $args = ( isset( $arguments[ 0 ] ) && ! is_null( $arguments[ 0 ] ) ) ? $arguments[ 0 ] : [];

      return new self::$htmlTags[ $name ]( $args );
    }
  }
}