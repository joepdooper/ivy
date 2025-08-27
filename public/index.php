<?php

use Ivy\Core\App;
use Ivy\Manager\AssetManager;
use Ivy\Model\Info;
use Ivy\Core\Path;
use Ivy\View\View;

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', __DIR__ . '/../logs/php_error.txt');

// Autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../autoloader.php';

$app = new App;
$app->run();
?>

<!DOCTYPE html>
<html lang="<?= substr(Info::getStash()['language']->value, 0, 2); ?>" data-color-mode="dark">
<head>

    <?php View::head('head.latte'); ?>

    <?php foreach (AssetManager::getCss() as $cssfile): ?>
        <link href="<?= $cssfile; ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>

</head>
<body>

<?php View::body('body.latte'); ?>

<?php foreach (AssetManager::getESM() as $esmfile): ?>
    <script type="module" src="<?= Path::get('BASE_PATH') . $esmfile; ?>"></script>
<?php endforeach; ?>

<?php foreach (AssetManager::getJS() as $jsfile): ?>
    <script src="<?= Path::get('BASE_PATH') . $jsfile; ?>"></script>
<?php endforeach; ?>

</body>
</html>
