<?php

namespace WPXFollowgramLight\WPBones\Database\Migrations;

class Migration {

  protected $charsetCollate = 'dummy_charset_collate';
  protected $tablename      = 'dummy_table_name';


  public function __construct()
  {
    global $charset_collate;
    global $wpdb;

    $this->charsetCollate = $charset_collate;
    $this->tablename      = $wpdb->prefix . strtolower( get_called_class() );

    $this->up();
  }

  // Override
  public function up()
  {
    // You may override this method on plugin activation
  }

  // Override
  public function down()
  {
    // You may override this method on plugin deactivation
  }

  protected function create( $sql )
  {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
  }

  protected function tablename()
  {

  }
}