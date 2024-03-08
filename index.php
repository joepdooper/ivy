<?php
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', 'logs/php_error.txt');

// Init session
session_start();

// Include paths
require 'core/include/const.php';

// Include init
require 'core/include/init.php';

?>
<!DOCTYPE html>
<html lang="<?php echo substr(\Ivy\Setting::$cache['language']->value, 0, 2); ?>">
<head>

    <?php
    $hooks->do_action('start_head_action');
    include \Ivy\Template::setTemplateFile('head.php');
    $hooks->do_action('end_head_action');
    ?>

    <script>
        const _SUBFOLDER = "<?php print _SUBFOLDER; ?>";
    </script>

    <?php $hooks->do_action('add_css_action');?>

    <?php if(\Ivy\Setting::$cache['minify_css']->bool): ?>
        <link defer href="<?php print _BASE_PATH . \Ivy\Template::setTemplateFile('css/minified.css'); ?>" rel="stylesheet" type="text/css">
    <?php else: ?>
        <?php foreach(\Ivy\Template::$css as $cssfile): ?>
            <link defer href="<?php print _BASE_PATH . \Ivy\Template::setTemplateFile($cssfile); ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>

<?php $hooks->do_action('start_body_action'); ?>

<div class="theme-container">
    <?php $hooks->do_action('start_wrapper_action'); ?>

    <?php
    $hooks->do_action('start_header_action');
    include \Ivy\Template::setTemplateFile('header.php');
    $hooks->do_action('end_header_action');
    ?>

    <?php
    $msg = new \Ivy\Message();
    $msg->tpl = \Ivy\Template::setTemplateFile('include/message.php');
    $msg->display();
    ?>

    <?php
    $hooks->do_action('start_main_action');
    include \Ivy\Template::setTemplateFile('main.php');
    $hooks->do_action('end_main_action');
    ?>

    <?php
    $hooks->do_action('start_footer_action');
    include \Ivy\Template::setTemplateFile('footer.php');
    $hooks->do_action('end_footer_action');
    ?>

    <?php $hooks->do_action('end_wrapper_action'); ?>
</div>

<?php $hooks->do_action('add_js_action'); ?>

<?php if(!empty(\Ivy\Template::$esm)): ?>
    <?php foreach(\Ivy\Template::$esm as $esmfile): ?>
        <script type="module" src="<?php print _BASE_PATH . \Ivy\Template::setTemplateFile($esmfile); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(\Ivy\Setting::$cache['minify_js']->bool): ?>
    <script src="<?php print _BASE_PATH . \Ivy\Template::setTemplateFile('js/minified.js'); ?>"></script>
<?php else: ?>
<?php foreach(\Ivy\Template::$js as $jsfile): ?>
    <script src="<?php print _BASE_PATH . \Ivy\Template::setTemplateFile($jsfile); ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

<?php $hooks->do_action('end_body_action'); ?>

</body>
</html>
