<?php

/*
|--------------------------------------------------------------------------
| Plugin Menus routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the menu routes for a plugin.
| In this context the route are the menu link.
|
*/

return [
  'wpx_followgram_light_slug_menu' => [
    "page_title" => "Followgram",
    "menu_title" => "Followgram",
    'capability' => 'read',
    'icon'       => 'logo-16x16.png',
    'items'      => [
      [
        "page_title" => __( 'Account Settings', 'wpx-followgram-light' ),
        "menu_title" => __( 'Account Settings', 'wpx-followgram-light' ),
        'capability' => 'read',
        'route'      => [
          'get'  => 'Dashboard\DashboardController@index',
          'post' => 'Dashboard\DashboardController@save',
        ],
      ],
      [
        "page_title" => __( 'Widget', 'wpx-followgram-light' ),
        "menu_title" => __( 'Widget', 'wpx-followgram-light' ),
        'capability' => 'read',
        'route'      => [
          'get' => 'Dashboard\DashboardController@widget',
        ],
      ],
    ]
  ]
];
