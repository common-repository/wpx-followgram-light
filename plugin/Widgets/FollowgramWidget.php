<?php

namespace WPXFollowgramLight\Widgets;

use WPXFollowgramLight\WPBones\Support\Widget;

class FollowgramWidget extends Widget
{

  /**
   * Base ID for the widget, lower case, if left empty a portion of the widget's class name will be used. Has to be
   * unique.
   *
   * @var string
   */
    public $id_base = 'followgram-widget';

    /**
     * Name for the widget displayed on the configuration page.
     *
     * @var string
     */
    public $name = 'Followgram';

    /**
     * Optional. Passed to wp_register_sidebar_widget()
     *
     * - description: shown on the configuration page
     * - classname
     *
     * @var array
     */
    public $widget_options = [
    'deccription' => 'Displays Followgram profile.'
  ];

    /**
     * Optional. Passed to wp_register_widget_control()
     *
     * - width: required if more than 250px
     * - height: currently not used but may be needed in the future
     *
     * @var array
     */
    public $control_options = [
    'width'  => 400,
    'height' => 350,
  ];

    public function update($new_instance, $old_instance)
    {
        $old_instance[ 'title' ]         = ($new_instance[ 'title' ]);
        $old_instance[ 'size' ]          = esc_attr($new_instance[ 'size' ]);
        $old_instance[ 'photo_number' ]  = ! empty($new_instance[ 'photo_number' ]) ? absint(esc_attr($new_instance[ 'photo_number' ])) : '4';
        $old_instance[ 'enabled_cache' ] = isset($new_instance[ 'enabled_cache' ]) ? $new_instance[ 'enabled_cache' ] : '';
        $old_instance[ 'cacheduration' ] = $new_instance[ 'cacheduration' ];
        $old_instance[ 'theme' ]         = $new_instance[ 'theme' ];

        return $old_instance;
    }

    /**
     * Retrun a key pairs array with the default value for widget.
     *
     * @return array
     */
    public function defaults()
    {
        return [
      'title'         => __('My instagrams', 'wpx-followgram-light'),
      'size'          => 'small',
      'photo_number'  => '4',
      'theme'         => 'wpxfollowgram-widget-default.min.css',
      'enabled_cache' => 'on',
      'cacheduration' => 3600,
    ];
    }

    public function viewForm($instance)
    {
        $instance = array_merge($this->defaults(), $instance);

        return WPXFollowgramLight()->view('widgets.form')
                               ->with([ 'instance' => $instance, 'widget' => $this ]);
    }

    public function viewWidget($args, $instance)
    {
        extract($args);

        // Get the title.
        $title = apply_filters('widget_title', $instance[ 'title' ]);
        // Get cached duration.
        $enabled_cache = $instance[ 'enabled_cache' ];
        $cacheduration = empty($instance[ 'cacheduration' ]) ? 3600 : $instance[ 'cacheduration' ];

        // Check for cached transient.
        $transient_name = sprintf('wpxf_%s', WPXFollowgramLight()->options->get('account.user_id'));
        $profile        = get_transient($transient_name);

        if (empty($profile) || 'on' !== $enabled_cache) {

            // Get data profile.
            $profile   = $this->getProfile();
            $serialize = json_encode($profile);

            if ('on' === $enabled_cache) {
                set_transient($transient_name, $serialize, $cacheduration);
            }
        } else {
            $profile = json_decode($profile);
        }

        return WPXFollowgramLight()
        ->view('widgets.index')
        ->with([
                'instance' => $instance,
                'title'    => $title,
                'profile'  => $profile
              ]);
    }

    /**
     * Get the user profile
     *
     * @return mixed
     */
    private function getProfile()
    {
        $account_user_id = WPXFollowgramLight()->options->get('account.user_id');
        $account_api_key = WPXFollowgramLight()->options->get('account.api_key');

        // Check configuration.
        if (! empty($account_user_id) && ! empty($account_api_key)) {
            $args = array(
        'userid' => WPXFollowgramLight()->options->get('account.user_id'),
        'token'  => WPXFollowgramLight()->options->get('account.api_key')
      );

            $response = $this->request('user/info/?clientid=' . WPXFollowgramLight()->config('followgram.followgram_id'), $args);

            if (! is_wp_error($response) &&
           $response[ 'response' ][ 'code' ] < 400 &&
           $response[ 'response' ][ 'code' ] >= 200
      ) {
                $data = json_decode($response[ 'body' ]);

                return $data->data;
            }
        }

        return false;
    }

    /**
     * Do a request to the wpXtreme Server.
     *
     * @param string $resource Resource, ie. `profile/user/11`
     * @param array  $args     (Optional) parameters
     *
     * @return \WP_Error|array|bool The response or WP_Error on failure.
     */
    private function request($resource, $args = array())
    {

    // Casting to array
        if (! is_array($args)) {
            $args = array( 'param' => $args );
        }

        // Prepare array for request.
        $params = array(
      'method'      => 'POST',
      'timeout'     => WPXFollowgramLight()->config('followgram.connection_timeout'),
      'redirection' => 5,
      'httpversion' => '1.0',
      'user-agent'  => WPXFollowgramLight()->config('followgram.user_agent'),
      'blocking'    => true,
      'headers'     => array(),
      'cookies'     => array(),
      'body'        => $args,
      'compress'    => false,
      'decompress'  => true,
      'sslverify'   => true,
    );

        if (! empty($resource)) {
            $endpoint = sprintf('%s%s', trailingslashit(WPXFollowgramLight()->config('followgram.api_endpoint')), $resource);
            $request  = wp_remote_request($endpoint, $params);

            if (200 != wp_remote_retrieve_response_code($request)) {
                return false;
            }

            return $request;
        }

        return false;
    }
}
