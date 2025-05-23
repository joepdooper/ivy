<?php

use Ivy\App;
use Ivy\Manager\AssetManager;
use Ivy\Manager\TemplateManager;
use Ivy\Path;
use Ivy\Model\Setting;
use Ivy\View\LatteView;

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

    <?php LatteView::head('head.latte'); ?>

    <script>
        const _SUBFOLDER = "<?= Path::get('SUBFOLDER'); ?>";
    </script>

    <?php
    if (Setting::getStash()['minify_css']->bool) {
        if (!file_exists(TemplateManager::file('css/minified.css'))) {
            $minify = new MatthiasMullie\Minify\CSS();
            foreach (AssetManager::getCss() as $cssfile) {
                $minify->add($cssfile);
            }
            $minify->minify(Path::get('PUBLIC_PATH') . _TEMPLATE_SUB . 'css/minified.css');
        }
    } else {
        $fileCSS = TemplateManager::file('css/minified.css');
        if ($fileCSS && file_exists($fileCSS)) {
            unlink($fileCSS);
        }
    }
    ?>

    <?php if (Setting::getStash()['minify_css']->bool): ?>
        <link href="<?= Path::get('BASE_PATH') . TemplateManager::file('css/minified.css'); ?>" rel="stylesheet" type="text/css">
    <?php else: ?>
        <?php foreach (AssetManager::getCss() as $cssfile): ?>
            <link href="<?= Path::get('BASE_PATH') . $cssfile; ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>

<?php LatteView::body('body.latte'); ?>

<?php
if (Setting::getStash()['minify_js']->bool) {
    if (!file_exists(TemplateManager::file('js/minified.js'))) {
        $minify = new MatthiasMullie\Minify\JS();
        foreach (AssetManager::getJS() as $jsfile) {
            $minify->add($jsfile);
        }
        $minify->minify(Path::get('PUBLIC_PATH') . _TEMPLATE_SUB . 'js/minified.js');
    }
} else {
    $fileJS = TemplateManager::file('js/minified.js');
    if ($fileJS && file_exists($fileJS)) {
        unlink($fileJS);
    }
}
?>

<?php foreach (AssetManager::getESM() as $esmfile): ?>
    <script type="module" src="<?= Path::get('BASE_PATH') . $esmfile; ?>"></script>
<?php endforeach; ?>

<?php if (Setting::getStash()['minify_js']->bool): ?>
    <script src="<?= Path::get('BASE_PATH') . TemplateManager::file('js/minified.js'); ?>"></script>
<?php else: ?>
<?php foreach (AssetManager::getJS() as $jsfile): ?>
    <script src="<?= Path::get('BASE_PATH') . $jsfile; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

</body>
</html>
