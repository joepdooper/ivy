<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<form action="<?php print _BASE_PATH . 'admin/user/logout'; ?>" method="POST" enctype="multipart/form-data">
  <div class="admin-container">

    <div class="inner">
      <div class="text-align-center">
        <div class="outer">
          <div class="inner">
            <?php $button->submit('logout'); ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</form>
