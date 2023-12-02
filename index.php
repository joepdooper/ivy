<?php
// error_reporting(E_ALL);
// ini_set('ignore_repeated_errors', TRUE);
// ini_set('display_errors', TRUE);
// ini_set('log_errors', TRUE);
// ini_set('error_log', 'logs/php_error.txt');

// Init session
session_start();

// Include paths
require 'core/include/const.php';

// Include start
require 'core/include/init.php';
$hooks->do_action('add_start_action');

// create router instance
$router = new \Bramus\Router\Router();
$router->setBasePath(_SUBFOLDER);

// Route
$hooks->do_action('start_router_action');
include _PUBLIC_PATH . 'core/include/route.php';
$hooks->do_action('end_router_action');

// run router instance
$router->run();
?>
<!DOCTYPE html>
<html lang="<?php echo $info['language']->value; ?>">
<head>

  <?php
  $hooks->do_action('start_head_action');
  include $page->setTemplateFile('head.php');
  $hooks->do_action('end_head_action');
  ?>

  <?php $hooks->do_action('add_css_action');?>

  <?php if($option['minify_css']->bool): ?>
  	<link defer href="<?php print _BASE_PATH . $page->setTemplateFile('css/minified.css'); ?>" rel="stylesheet" type="text/css">
  <?php else: ?>
  	<?php foreach($page->css as $cssfile): ?>
  		<link defer href="<?php print _BASE_PATH . $page->setTemplateFile($cssfile); ?>" rel="stylesheet" type="text/css">
  	<?php endforeach; ?>
  <?php endif; ?>

</head>
<body>
  <?php $hooks->do_action('start_body_action'); ?>

  <div class="wrapper theme-container">
    <?php $hooks->do_action('start_wrapper_action'); ?>

    <?php
    $hooks->do_action('start_header_action');
    include $page->setTemplateFile('header.php');
    $hooks->do_action('end_header_action');

    $hooks->do_action('start_message_action');
    $msg = new \Ivy\Message();
    $msg->tpl = $page->setTemplateFile('content/message.php');
    $msg->display();
    $hooks->do_action('end_message_action');
    ?>

      <?php
      // create router instance
      $router = new \Bramus\Router\Router();
      $router->setBasePath(_SUBFOLDER);
      ?>

      <?php $hooks->do_action('start_container_action'); ?>
      <?php include _PUBLIC_PATH . 'core/include/pages.php'; ?>
      <?php $hooks->do_action('end_container_action'); ?>

      <?php
      // run router instance
      $router->run();
      ?>

    <?php $hooks->do_action('end_wrapper_action'); ?>
  </div>

  <?php
  $hooks->do_action('start_footer_action');
  include $page->setTemplateFile('footer.php');
  $hooks->do_action('end_footer_action');
  ?>

  <?php $hooks->do_action('add_js_action'); ?>

  <?php if($option['minify_js']->bool): ?>
  	<script src="<?php print _BASE_PATH . $page->setTemplateFile('js/minified.js'); ?>"></script>
  <?php else: ?>
  	<?php foreach($page->js as $jsfile): ?>
  		<script src="<?php print _BASE_PATH . $page->setTemplateFile($jsfile); ?>"></script>
  	<?php endforeach; ?>
  <?php endif; ?>

  <?php $hooks->do_action('start_script_action'); ?>
  <?php include_once $page->setTemplateFile('content/script.php'); ?>
  <?php $hooks->do_action('end_script_action'); ?>

  <?php $hooks->do_action('end_body_action'); ?>

</body>
</html>
