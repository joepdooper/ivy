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

global $hooks;
?>
<!DOCTYPE html>
<html lang="<?php echo substr(\Ivy\Setting::$cache['language']->value, 0, 2); ?>" data-color-mode="dark">
<head>

    <?php
    $hooks->do_action('start_head_action');
    include \Ivy\Template::position('head');
    $hooks->do_action('end_head_action');
    ?>

    <script>
        const _SUBFOLDER = "<?php print _SUBFOLDER; ?>";
    </script>

    <?php $hooks->do_action('add_css_action');?>

    <?php
    if(\Ivy\Setting::$cache['minify_css']->bool){
        if(!file_exists(\Ivy\Template::file('css/minified.css'))){
            $minify = new MatthiasMullie\Minify\CSS();
            foreach(\Ivy\Template::$css as $cssfile){
                $sourcePath = \Ivy\Template::file($cssfile);
                $minify->add($sourcePath);
            }
            $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'css/minified.css');
        }
    } else {
        if(file_exists(\Ivy\Template::file('css/minified.css'))){
            unlink(\Ivy\Template::file('css/minified.css'));
        }
    }
    ?>

    <?php if(\Ivy\Setting::$cache['minify_css']->bool): ?>
        <link href="<?php print _BASE_PATH . \Ivy\Template::file('css/minified.css'); ?>" rel="stylesheet" type="text/css">
    <?php else: ?>
        <?php foreach(\Ivy\Template::$css as $cssfile): ?>
            <link href="<?php print _BASE_PATH . \Ivy\Template::file($cssfile); ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>

<?php
$hooks->do_action('start_body_action');
include \Ivy\Template::position('body');
$hooks->do_action('end_body_action');
?>

<?php $hooks->do_action('add_js_action'); ?>

<?php
if(\Ivy\Setting::$cache['minify_js']->bool){
    if(!file_exists(\Ivy\Template::file('js/minified.js'))){
        $minify = new MatthiasMullie\Minify\JS();
        foreach(\Ivy\Template::$js as $jsfile){
            $sourcePath = \Ivy\Template::file($jsfile);
            $minify->add($sourcePath);
        }
        $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'js/minified.js');
    }
} else {
    if(file_exists(\Ivy\Template::file('js/minified.js'))){
        unlink(\Ivy\Template::file('js/minified.js'));
    }
}
?>

<?php if(!empty(\Ivy\Template::$esm)): ?>
    <?php foreach(\Ivy\Template::$esm as $esmfile): ?>
        <script type="module" src="<?php print _BASE_PATH . \Ivy\Template::file($esmfile); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(\Ivy\Setting::$cache['minify_js']->bool): ?>
    <script src="<?php print _BASE_PATH . \Ivy\Template::file('js/minified.js'); ?>"></script>
<?php else: ?>
<?php foreach(\Ivy\Template::$js as $jsfile): ?>
    <script src="<?php print _BASE_PATH . \Ivy\Template::file($jsfile); ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

</body>
</html>
