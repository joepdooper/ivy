<?php

use Ivy\App;
use Ivy\Path;
use Ivy\Setting;
use Ivy\Template;

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', 'logs/php_error.txt');

// Autoloader
require_once 'vendor/autoload.php';
require_once 'autoloader.php';

$app = new App;
$app->run();
?>

<!DOCTYPE html>
<html lang="<?= substr(Setting::getStash()['language']->value, 0, 2); ?>" data-color-mode="dark">
<head>

    <?php
    Template::hooks()->do_action('before_head_action');
    Template::head('head.latte');
    Template::hooks()->do_action('after_head_action');
    ?>

    <script>
        const _SUBFOLDER = "<?= Path::get('SUBFOLDER'); ?>";
    </script>

    <?php Template::hooks()->do_action('add_css_action'); ?>

    <?php
    if (Setting::getStash()['minify_css']->bool) {
        if (!file_exists(Template::file('css/minified.css'))) {
            $minify = new MatthiasMullie\Minify\CSS();
            foreach (Template::getCss() as $cssfile) {
                $minify->add($cssfile);
            }
            $minify->minify(Path::get('PUBLIC_PATH') . _TEMPLATE_SUB . 'css/minified.css');
        }
    } else {
        if (file_exists(Template::file('css/minified.css'))) {
            unlink(Template::file('css/minified.css'));
        }
    }
    ?>

    <?php if (Setting::getStash()['minify_css']->bool): ?>
        <link href="<?= Path::get('BASE_PATH') . Template::file('css/minified.css'); ?>" rel="stylesheet" type="text/css">
    <?php else: ?>
        <?php foreach (Template::getCss() as $cssfile): ?>
            <link href="<?= Path::get('BASE_PATH') . $cssfile; ?>" rel="stylesheet" type="text/css">
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
if (Setting::getStash()['minify_js']->bool) {
    if (!file_exists(Template::file('js/minified.js'))) {
        $minify = new MatthiasMullie\Minify\JS();
        foreach (Template::getJs() as $jsfile) {
            $minify->add($jsfile);
        }
        $minify->minify(Path::get('PUBLIC_PATH') . _TEMPLATE_SUB . 'js/minified.js');
    }
} else {
    if (file_exists(Template::file('js/minified.js'))) {
        unlink(Template::file('js/minified.js'));
    }
}
?>

<?php foreach (Template::getEsm() as $esmfile): ?>
    <script type="module" src="<?= Path::get('BASE_PATH') . Template::file($esmfile); ?>"></script>
<?php endforeach; ?>

<?php if (Setting::getStash()['minify_js']->bool): ?>
    <script src="<?= Path::get('BASE_PATH') . Template::file('js/minified.js'); ?>"></script>
<?php else: ?>
<?php foreach (Template::getJs() as $jsfile): ?>
    <script src="<?= Path::get('BASE_PATH') . $jsfile; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

</body>
</html>
