<!--
 |
 | In $plugin you'll find an instance of Plugin class.
 | If you'd like can pass variable to this view, for example:
 |
 | return PluginClassName()->view( 'dashboard.index', [ 'var' => 'value' ] );
 |
-->

<div class="wpx-followgram-light wrap">
  <h1>Followgram</h1>

  <h2>Api keys</h2>

  <?php if ( isset( $feedback ) ) : ?>
    <div class="notice notice-success is-dismissible">
      <p>
        <?php echo $feedback ?>
      </p>
    </div>
  <?php endif; ?>

  <form method="post" action="">
    <?php wp_nonce_field( 'followgram-options' ); ?>

    <table class="form-table">
      <tbody>

      <tr>
        <th scope="row">
          <label for="account/user_id">User Id</label>
        </th>
        <td>
          <input type="text"
                 id="account/user_id"
                 name="account/user_id"
                 value="<?php echo $plugin->options->get( 'account.user_id' ) ?>"
                 size="48"
                 placeholder="Your Followgram User Id"/>
        </td>
      </tr>

      <tr>
        <th scope="row">
          <label for="account/api_key">API Key</label>
        </th>
        <td>
          <input type="text"
                 id="account/api_key"
                 name="account/api_key"
                 value="<?php echo $plugin->options->get( 'account.api_key' ) ?>"
                 size="48"
                 placeholder="Your Followgram API Key"/>
        </td>
      </tr>

      </tbody>
    </table>


    <p class="submit">
      <button class="button button-primary">Save Changes</button>
    </p>

  </form>

</div>