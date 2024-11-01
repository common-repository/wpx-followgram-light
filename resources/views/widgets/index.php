<?php
// Get some useful properties.
$followgram_link = sprintf('http://followgram.me/%s', $profile->info->username);

// Photo number.
$photo_number = $instance[ 'photo_number' ];

// Photo size.
$photo_size = $instance[ 'size' ];

// Include custom style sheets.
$theme = $instance[ 'theme' ];
$style = file_get_contents(WPXFollowgramLight()->images . '/' . $theme);
printf('<style type="text/css">%s</style>', $style);

echo $title;
?>

<div class="wpx-followgram-widget clearfix">
  <div class="wpx-followgram-profile clearfix">
    <a class="wpx-followgram-profile-image"
      href="<?php echo $followgram_link ?>">
      <img src="<?php echo $profile->info->profile_picture ?>"
        alt="<?php echo $profile->info->full_name ?>" />
    </a>
    <a class="wpx-followgram-profile-name"
      href="<?php echo $followgram_link ?>">
      <?php echo $profile->info->full_name ?>
      <span>on</span><br /><span>instagram</span>
    </a>
  </div>

  <table class="wpx-followgram-infos" border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <a href="<?php echo $followgram_link ?>">
          <span class="wpx-followgram-count"><?php echo $profile->info->counts->media ?></span>
          <span>Photo</span>
        </a>
      </td>
      <td>
        <a href="<?php echo $followgram_link ?>/following">
          <span class="wpx-followgram-count"><?php echo $profile->info->counts->follows ?></span>
          <span>Following</span>
        </a>
      </td>
      <td>
        <a href="<?php echo $followgram_link ?>/follower">
          <span class="wpx-followgram-count"><?php echo $profile->info->counts->followed_by ?></span>
          <span>Follower</span>
        </a>
      </td>
    </tr>
  </table>

  <div class="wpx-followgram-photos clearfix">

    <?php
    $count = 1;
    foreach ($profile->photos as $photo) : ?>
    <a href="http://followgram.me/i/<?php echo $photo->id ?>"
      target="_blank">
      <img class="<?php echo $photo_size ?>"
        src="<?php echo $photo->images->low_resolution->url ?>"
        alt="<?php echo isset($photo->caption) ? $photo->caption->text : '' ?>'"
        title="<?php echo isset($photo->caption) ? $photo->caption->text : '' ?>'"
        border="0" />
    </a>
    <?php if (++$count > $photo_number) {
        break;
    } ?>
    <?php endforeach; ?>
  </div>

  <div class="wpx-follogram-firm clearfix">
    <a rel="<?php echo WPXFollowgramLight()->options->get('account.user_id') ?>"
      href="http://followgram.me/<?php echo $profile->info->username ?>"
      username="<?php echo $profile->info->username ?>"
      class="followgrambutton">@<?php echo $profile->info->username ?></a>
    <script src="http://external.followgram.me/v1/follow/js/" type="text/javascript"></script>

  </div>

  <div class="wpx-followgram-visit clearfix">
    Visit <a href="http://followgram.me">Followgram.me</a>
  </div>

</div>