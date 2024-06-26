<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Button;
use Ivy\User;
global $auth;
?>

<footer class="bg-secondary position-relative">
  <?php if(User::canEditAsAdmin($auth)): ?>
    <nav class="menu">
      <ul>
        <li>
          <label for="overlay-mode" class="button">
            <?php print file_get_contents(_PUBLIC_PATH . "/media/icon/" . "feather/plus.svg"); ?>
          </label>
        </li>
        <li>
          <?php (new Button)::link(_BASE_PATH . 'admin/setting',null,'feather/sliders.svg','Settings'); ?>
        </li>
        <li>
          <?php (new Button)::link(_BASE_PATH . 'admin/template',null,'feather/layout.svg','Templates'); ?>
        </li>
        <li>
          <?php (new Button)::link(_BASE_PATH . 'admin/plugin',null,'feather/package.svg','Plugins'); ?>
        </li>
        <li>
          <?php (new Button)::link(_BASE_PATH . 'admin/user',null,'feather/users.svg','Users'); ?>
        </li>
        <?php if (in_array("Tag", $_SESSION['plugin_actives'])):?>
          <li>
            <?php (new Button)::link(_BASE_PATH . 'plugin/Tag',null,'feather/tag.svg','Tags'); ?>
          </li>
        <?php endif;?>
      </ul>
    </nav>
  <?php else: ?>
    <div class="text-align-center inner">
      Build with <a href="https://github.com/joepdooper/ivy"><strong>ivy</strong></a> © <?php print date("Y"); ?>
    </div>
  <?php endif; ?>
</footer>
