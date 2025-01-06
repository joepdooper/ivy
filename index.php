<?php

use Ivy\App;
use Ivy\Setting;
use Ivy\Template;

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', 'logs/php_error.txt');

// Init session
session_start();

// Include paths
require_once 'include/const.php';
require_once 'vendor/autoload.php';
require_once 'include/autoloader.php';
require_once 'include/functions.php';

$app = new App;
$app->loadCoreRoutesAssets('include/routes.php');
$app->run();
?>

<!DOCTYPE html>
<html lang="<?= substr(Setting::getFromStashByKey('language')->value, 0, 2); ?>" data-color-mode="dark">
<head>

    <?php
    Template::hooks()->do_action('before_head_action');
    Template::head('head.latte');
    Template::hooks()->do_action('after_head_action');
    ?>

    <script>
        const _SUBFOLDER = "<?= _SUBFOLDER; ?>";
    </script>

    <?php Template::hooks()->do_action('add_css_action'); ?>

    <?php
    if (Setting::getFromStashByKey('minify_css')->bool) {
        if (!file_exists(Template::file('css/minified.css'))) {
            $minify = new MatthiasMullie\Minify\CSS();
            foreach (Template::$css as $cssfile) {
                $minify->add($cssfile);
            }
            $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'css/minified.css');
        }
    } else {
        if (file_exists(Template::file('css/minified.css'))) {
            unlink(Template::file('css/minified.css'));
        }
    }
    ?>

    <?php if (Setting::getFromStashByKey('minify_css')->bool): ?>
        <link href="<?= _BASE_PATH . Template::file('css/minified.css'); ?>" rel="stylesheet" type="text/css">
    <?php else: ?>
        <?php foreach (Template::$css as $cssfile): ?>
            <link href="<?= _BASE_PATH . $cssfile; ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>

<?php
Template::hooks()->do_action('before_body_action');
Template::body('body.latte');
Template::hooks()->do_action('after_body_action');
?>

<?php Template::hooks()->do_action('add_js_action'); ?>

<?php
if (Setting::getFromStashByKey('minify_js')->bool) {
    if (!file_exists(Template::file('js/minified.js'))) {
        $minify = new MatthiasMullie\Minify\JS();
        foreach (Template::$js as $jsfile) {
            $minify->add($jsfile);
        }
        $minify->minify(_PUBLIC_PATH . _TEMPLATE_SUB . 'js/minified.js');
    }
} else {
    if (file_exists(Template::file('js/minified.js'))) {
        unlink(Template::file('js/minified.js'));
    }
}
?>

<?php if (!empty(Template::$esm)): ?>
    <?php foreach (Template::$esm as $esmfile): ?>
        <script type="module" src="<?= _BASE_PATH . Template::file($esmfile); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (Setting::getFromStashByKey('minify_js')->bool): ?>
    <script src="<?= _BASE_PATH . Template::file('js/minified.js'); ?>"></script>
<?php else: ?>
<?php foreach (Template::$js as $jsfile): ?>
    <script src="<?= _BASE_PATH . $jsfile; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

</body>
</html>
