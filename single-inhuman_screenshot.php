<?php
  get_header('post');
  wp_enqueue_style('post', get_template_directory_uri() . "/styles/post.css");
  $meta = get_post_meta(get_the_ID());
  $edit = isset($_GET['edit']);
  $isowner = is_user_logged_in() && $post->post_author == get_current_user_id();

  $likes = get_post_meta(get_the_ID(), "inhuman_meta_total_like_count", true);
  if (!$likes)
    $likes = 0;
?>
<?php get_sidebar(); ?>

<input id="post_id" type="hidden" value="<?php echo get_the_ID(); ?>">

<div class="content">
  <?php if($edit && $isowner): ?>
    <?php if (get_user_meta(get_current_user_id(), "inhuman_user_complete", true)): ?>
      <div class="screenshot-edit">
        <div class="screenshot-card">
          <?php the_post_thumbnail('full'); ?>
        </div>
        <form id="screenshot-meta-form">
          <input type="hidden" name="post_id" value="<?php the_ID(); ?>" />
          <input class="meta-caption" name="caption" type="text" value="<?php the_title(); ?>" placeholder="Caption" />
          <input class="meta-brand" name="brand" type="text" value="<?php echo $meta['inhuman_meta_ad_brand'][0]; ?>" placeholder="Ad Brand" />
          <input class="meta-domain" name="domain" type="text" value="<?php echo $meta['inhuman_meta_publisher_domain'][0]; ?>" placeholder="(unknown domain)" disabled="disabled" />
          <div class="meta-offensive-wrapper">
            <input class="meta-offensive" name="offensive" type="checkbox" />
            <label for="offensive">This screenshot might be offensive to some.</label>
          </div>
          <input type="submit" class="button button-primary button-raised" value="Post" />
        </form>
      </div>
    <?php else: ?>
      <p>Looks like you're new around here!</p>
      <p>Set a username and optional email (for account recovery) to
        post your first screenshot:</p>
      <form id="user-setup">
        <div>
          <label for="name">Name:</label>
          <input type="text" name="name" value="<?php echo user()->display_name; ?>">
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="text" name="email" placeholder="(optional)">
        </div>
        <input type="button" class="button button-primary" value="Submit">
      </form>
    <?php endif; ?>

  <?php else: ?>
    <div class="screenshot-card">
      <?php the_post_thumbnail('full'); ?>
      <div class="screenshot-meta">
        <span class="screenshot-caption"><?php the_title(); ?></span>
        <span class="screenshot-actions">
          <span class="like">
            <a class="like-link" href="#"><i class="fa fa-smile-o fa-lg"></i></a>
            <div class="like-box-wrapper">
              <div class="like-box">
                <a class="like-emoji-link" data-emoji="funny" href="#">
                  <img src="<?php tpldir(); ?>/assets/emojiicon-funny.svg">
                </a>
                <a class="like-emoji-link" data-emoji="angry" href="#">
                  <img src="<?php tpldir(); ?>/assets/emojiicon-angry.svg">
                </a>
                <a class="like-emoji-link" data-emoji="sad" href="#">
                  <img src="<?php tpldir(); ?>/assets/emojiicon-sad.svg">
                </a>
                <a class="like-emoji-link" data-emoji="huh" href="#">
                  <img src="<?php tpldir(); ?>/assets/emojiicon-huh.svg">
                </a>
              </div>
            </div>
          </span>

          <span class="share">
            <a class="share-link" href="#"><i class="fa fa-share-square-o fa-lg"></i></a>
            <div class="share-box-wrapper">
              <div class="share-box">
                <a class="twitter-share-button"
                   href="http://twitter.com/intent/tweet?status=<?php echo urlencode(get_the_title() . " " . get_permalink() . " #inhumanads"); ?>">
                  <i class="fa fa-twitter-square fa-3x"></i></a>
                <a class="facebook-share-button"
                   href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>">
                  <i class="fa fa-facebook-square fa-3x"></i></a>
                <a class="email-share-button"
                   href="mailto:?Subject=<?php echo urlencode(get_the_title() . "\n" . get_permalink()); ?>">
                  <i class="fa fa-envelope-square fa-3x"></i></a>
              </div>
            </div>
          </span>
        </span>
        <div class="like-emoji-count-box">
          <img src="<?php tpldir(); ?>/assets/emojiicon-funny.svg">
          <span class="count-text"><?php echo $likes; ?></span>
        </div>
      </div>
      <div class="screenshot-meta-2">
        <span class="screenshot-brand">Brand: <?php echo $meta["inhuman_meta_ad_brand"][0]; ?></span>
        <span class="screenshot-domain">Spotted on: <?php echo $meta["inhuman_meta_publisher_domain"][0]; ?></span>
      </div>
      <a class="offensive" href="#">
        <i class="fa fa-warning"></i>
        <span class="report-txt">Report</span>
      </a>
    </div>

    <hr>

    <?php comments_template(); ?>
  <?php endif; ?>
</div>

<?php get_footer('post'); ?>
