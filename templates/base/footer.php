<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<footer class="bg-secondary position-relative">
  <?php if(canEditAsAdmin($auth)): ?>
    <nav class="menu">
      <ul>
        <li>
          <label for="overlay-mode" class="button">
            <?php print file_get_contents(_PUBLIC_PATH . "/media/icon/" . "feather/plus.svg"); ?>
          </label>
        </li>
        <li>
          <?php $button->link(_BASE_PATH . 'admin/setting',null,'feather/sliders.svg','Settings'); ?>
        </li>
        <li>
          <?php $button->link(_BASE_PATH . 'admin/template',null,'feather/layout.svg','Templates'); ?>
        </li>
        <li>
          <?php $button->link(_BASE_PATH . 'admin/plugin',null,'feather/package.svg','Plugins'); ?>
        </li>
        <li>
          <?php $button->link(_BASE_PATH . 'admin/user',null,'feather/users.svg','Users'); ?>
        </li>
        <?php if (in_array("Tag", $_SESSION['plugins_active'])):?>
          <li>
            <?php $button->link(_BASE_PATH . 'plugin/Tag',null,'feather/tag.svg','Tags'); ?>
          </li>
        <?php endif;?>
      </ul>
    </nav>
  <?php endif; ?>
</footer>
