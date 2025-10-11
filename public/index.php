<?php

use Ivy\Core\App;
use Ivy\Manager\AssetManager;
use Ivy\Manager\SecurityManager;
use Ivy\Model\Info;
use Ivy\Core\Path;
use Ivy\View\View;

// Autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../autoloader.php';

$app = new App;
$app->run();
?>

<!DOCTYPE html>
<html lang="<?= substr(Info::stashGet('language')->value, 0, 2); ?>" data-color-mode="dark">
<head>

    <?php View::head('head.latte'); ?>

    <?php foreach (AssetManager::getCss() as $cssfile): ?>
        <link href="<?= $cssfile; ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>
</head>
<body>

<?php View::body('body.latte'); ?>

<?php foreach (AssetManager::getJS() as $jsfile): ?>
    <script nonce="<?= SecurityManager::getNonce(); ?>" src="<?= Path::get('PUBLIC_URL') . $jsfile; ?>"></script>
<?php endforeach; ?>

<?php foreach (AssetManager::getViteEntry() as $viteEntry): ?>
    <script nonce="<?= SecurityManager::getNonce(); ?>" type="module" src="<?= $viteEntry; ?>"></script>
<?php endforeach; ?>
</body>
</html>
