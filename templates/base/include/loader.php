<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<input id="loading-mode" name="loading-mode" class="overlay-mode-checkbox d-none" type="checkbox">
<label class="overlay" for="loading-mode">
    <div class="loading">
        <div class="outer">
            <div class="inner text-align-center">
                <?php print file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/loader.svg"); ?>
            </div>
        </div>
    </div>
</label>