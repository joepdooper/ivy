<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
if(isset($_SESSION['auth_user_id'])):
  $profile = (new \Ivy\Profile)->where('id',$_SESSION['auth_user_id'])->getRow()->data();
endif;
?>

<div class="admin-container">

  <div class="outer">
    <div class="inner">
      <h1>Profile</h1>
    </div>
  </div>

  <div class="outer">

    <div class="inner">
      <?php foreach($auth->getRoles() as $key => $value): ?>
        <div class="badge">
          <small><strong><?php print $value; ?></strong></small>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="inner">

      <div class="form-group">
        <?php if ($profile->users_image):?>

          <div class="float-start users-image" style="background-image:url(<?php print _BASE_PATH . 'media/item/thumb/' . $profile->users_image; ?>)">
            <div class="editImageButton">
              <?php $button->delete('users_image','delete'); ?>
            </div>
          </div>

        <?php else: ?>

          <div class="float-start users-image" id="usersImagePreview">
            <div class="editImageButton">
              <?php $button->upload('users_image','upload'); ?>
            </div>
          </div>
          <script>
          window.addEventListener('DOMContentLoaded', (event) => {
            previewImage("users_image","usersImagePreview","background");
          });
          </script>

        <?php endif; ?>
      </div>

      <input name="users[id]" type="hidden" value="<?php print $profile->user_id; ?>">

      <div class="form-group">
        <input name="users[username]" type="text" placeholder="name" value="<?php print $auth->getUsername(); ?>">
      </div>

      <div class="form-group">
        <input name="users[email]" type="email" placeholder="email" value="<?php print $auth->getEmail(); ?>">
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
