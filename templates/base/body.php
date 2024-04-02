<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

use Ivy\Button;
use Ivy\ItemTemplate;
use Ivy\Message;
use Ivy\Template;
use Ivy\User;

global $hooks, $auth;
?>

<div class="theme-container">

    <?php
    $hooks->do_action('start_header_action');
    include Template::file('include/header.php');
    $hooks->do_action('end_header_action');
    ?>

    <?php
    $msg = new Message();
    $msg->tpl = 'include/message.php';
    $msg->display();
    ?>

    <main id="swup" class="flex-grow-1 transition-fade">

        <div class="container">
            <?php
            $hooks->do_action('start_main_action');
            include Template::position('main');
            $hooks->do_action('end_main_action');
            ?>
        </div>

        <?php if(User::canEditAsEditor($auth)): ?>
            <input id="overlay-mode" name="overlay-mode" class="overlay-mode-checkbox d-none" type="checkbox">
            <label class="overlay" for="overlay-mode">
                <div class="popup">
                    <div class="outer">
                        <div class="inner">
                            <?php
                            Button::close('close',"overlay-mode");
                            include Template::file('include/item_template_list.php', (new ItemTemplate)->get()->data());
                            ?>
                        </div>
                    </div>
                </div>
            </label>
        <?php endif; ?>

        <?php include Template::file('include/loader.php'); ?>

    </main>

    <?php
    $hooks->do_action('start_footer_action');
    include Template::file('include/footer.php');
    $hooks->do_action('end_footer_action');
    ?>

</div>
