<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
if(isset($_SESSION['auth_user_id'])):
  $profile = new \Ivy\Profile($_SESSION['auth_user_id']);
endif;
?>

<div class="maxwidth">

  <div class="outer">
    <div class="inner">
      <h1>Profile</h1>
    </div>
  </div>

  <div class="outer">

    <div class="inner">
      <?php foreach($auth->getRoles() as $key => $value): ?>
        <div class="role">
          <strong><?php print $value; ?></strong>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="inner">

      <div class="form-group">
        <?php if ($profile->image):?>

          <div class="users-image" style="background-image:url(<?php print _BASE_PATH . 'media/item/thumb/' . $profile->image; ?>)">
            <div class="editImageButton">
              <?php $button->delete('userimage','delete'); ?>
            </div>
          </div>

        <?php else: ?>

          <div class="users-image" id="userImagePreview">
            <div class="editImageButton">
              <?php $button->upload('userimage','upload'); ?>
            </div>
          </div>
          <script>
          window.addEventListener('DOMContentLoaded', (event) => {
            previewImage("userimage","userImagePreview","background");
          });
          </script>

        <?php endif; ?>
      </div>

      <div class="form-group">
        <input name="name" type="text" placeholder="name" value="<?php print $auth->getUsername(); ?>">
      </div>

      <div class="form-group">
        <input name="email" type="email" placeholder="email" value="<?php print $auth->getEmail(); ?>">
      </div>

      <!-- <div class="form-group">
      <input type="password" name="password" placeholder="password" value="">
    </div> -->

  </div>
</div>

<div class="outer">
  <div class="inner text-align-center">
    <?php $button->submit('update'); ?>
  </div>
</div>

</div>
