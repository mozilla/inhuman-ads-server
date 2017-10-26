<?php

  // Check that the nonce is valid, user is logged in
  if (isset($_POST['screenshot_upload_nonce'])
      && is_user_logged_in()
	    && wp_verify_nonce($_POST['screenshot_upload_nonce'], 'screenshot_upload')) {

	  // These files need to be included as dependencies when on the front end.
	  require_once( ABSPATH . 'wp-admin/includes/image.php' );
	  require_once( ABSPATH . 'wp-admin/includes/file.php' );
	  require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // create new screenshot post
    $post_id = wp_insert_post(array(
      'post_title'    => '',
      'post_content'  => '',
      'post_status'   => 'publish',
      'post_author'   => get_current_user_id(),
      'post_type' => 'inhuman_screenshot',
      'meta_input' => array(
        'inhuman_meta_type' => 'screenshot',
        'inhuman_meta_status' => 'draft'
      )
    ));

	  $attachment_id = media_handle_upload('screenshot_upload', $post_id);
    set_post_thumbnail($post_id, $attachment_id);

	  if (is_wp_error($attachment_id)) {
      echo "Error uploading image: " . $attachment_id;
	  } else {
      echo '<script>location = "/screenshot/' . $post_id . '?edit";</script>';
	  }
  }
?>

<?php get_header(); ?>
<?php wp_enqueue_style('post', get_template_directory_uri() . "/styles/contribute.css"); ?>

<div class="main">
  <img class="landing1" src="<?php tpldir(); ?>/assets/landing-screenshots_image_01_57.svg">
  <h2>Ready to call out some bad ads with us?</h2>

  <?php if (strlen(strstr($_SERVER['HTTP_USER_AGENT'], "Firefox")) > 0): ?>
    <p>It’s easy submitting inhuman ads with Firefox Screenshots!</p>

    <p>Firefox Screenshots is a new feature to take, download, collect
      and share screenshots.</p>

    <p>To submit a bad ad, you will need to click on the button below
      to install the Inhuman Ads add-on (no restart required):</p>

    <p><a id="install_button" href="https://addons.mozilla.org/firefox/downloads/latest/inhuman-ads/addon-841180-latest.xpi?src=dp-btn-primary" class="button button-primary">Activate Inhuman Ads</a></p>

    <p>Once the add-on is installed, simply take a screenshot and
      click the “Send to Inhuman Ads” button!</p>

    <img class="landing2" src="<?php tpldir(); ?>/assets/send-to-inhuman-ads.png">
  <?php else: ?>
    <p>It’s easy submitting inhuman ads with Firefox Screenshots!</p>

    <p>Firefox Screenshots is a new feature to take, download, collect
      and share screenshots. Get Firefox to try it out:</p>

    <p><a id="install_button" href="https://www.mozilla.org/firefox/new/?scene=2&utm_source=inhumanads.com&utm_medium=referral&utm_campaign=non-fx-button#download-fx" class="button button-primary">Only with Firefox — Get Firefox Now!</a></p>
  <?php endif; ?>

  <p>Don’t have Firefox Screenshots?</p>

  <p>No problem, but you should really give it a try! If you’ve
    already got a screenshot of an inhuman ad you would like to
    submit, click the button below:</p>


  <p>
    <form id="image_upload" method="post" action="#" enctype="multipart/form-data">
      <div class="upload-button button button-primary">
        Select file on your computer...
	      <input type="file" class="upload" name="screenshot_upload" id="screenshot_upload" value="" />
      </div><br>
	    <?php wp_nonce_field('screenshot_upload', 'screenshot_upload_nonce'); ?>
    </form>
  </p>

  <script>
    <?php if (is_user_logged_in()): ?>
      jQuery('#screenshot_upload').change(function() {
        jQuery('#image_upload').submit();
      });
    <?php else: ?>
      jQuery('#screenshot_upload').click(function(e) {
        e.preventDefault();
        location = "/login?orig_request=" + encodeURIComponent("/contribute");
      });
    <?php endif; ?>
  </script>

  <p>Now, go forth and browse, find the worst ads! Good luck with your
  newfound superpower — use it wisely.</p>
</div>

<div class="faq">
  <h2>Frequently Asked Questions</h2>

  <dl class="install-faq">
    <!-- 
         <dt>Can I upload screenshots that I have saved on my computer?</dt>
         <dd>Although we’d love to see the bizarre ads you’ve found in your journeys, inhuman ads can only come from Firefox Screenshots. That enables us to nab the URL where your ad came from and hold the publisher (i.e., the website where you found the ad) accountable.</dd>
       -->
    <dt>What is Firefox Screenshots?</dt>
    <dd>It’s a handy tool for taking screenshots of your window, screen, or a smaller selection from within Firefox. Just look for that little scissor cutting on a dotted line in your toolbar or in the three dots of your web address field. <a href="https://screenshots.firefox.com/">Learn more</a></dd>
    
    <dt>I am using Firefox Screenshots...but where’s the “Send to Inhuman Ads” button?</dt>
    <dd>Ah-ha, you’re almost there! Just <a href="https://addons.mozilla.org/en-US/firefox/addon/inhuman-ads/">install the Inhuman Ads add-on</a> and the next time you use Firefox Screenshots, the button will be there.</dd>
    
    <dt>Why does Mozilla hate ads?</dt>
    <dd>We 💜 good, creative ads that reach the right users and make sense in context. It’s the dark side — poorly placed ads that hurt our heads and eyes — that we’re trying to call out. Ad blockers don’t solve this problem, either. Indiscriminately blocking ads hurts the writers, visual artists, and other creato  rs that depend on ad revenue to fund their work. You, the consumer, deserve better ads.</dd>
  </dl>
</div>

<?php get_footer(); ?>
