<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Button;
use Ivy\Profile;
use Ivy\Setting;
use Ivy\Template;
global $hooks, $auth;
?>

<header id="header" class="bg-secondary position-relative">
    <?php if (isset(Template::$id)):?>
        <div class="float-start">
            <?php Button::link(_BASE_PATH,null,'feather/arrow-left.svg','Back'); ?>
        </div>
    <?php endif;?>
    <div class="float-start">
        <a id="logo" href="<?php echo _BASE_PATH;?>" title="<?php print Setting::$cache['name']->value; ?>">
            <?php print Setting::$cache['name']->value; ?>
        </a>
    </div>
    <?php
    // Hook from DarkMode plugin
    $hooks->do_action('dark_mode_buttons');
    ?>
    <nav class="menu float-end">
        <ul>
            <?php if($auth->isLoggedIn()): ?>
                <li>
                    <?php
                    if(isset($_SESSION['auth_user_id'])){
                        $profile = (new Profile)->where('user_id',$_SESSION['auth_user_id'])->getRow()->data();
                    }
                    ?>
                    <?php if(isset($profile->users_image)): ?>
                    <a href="<?php print _BASE_PATH . 'admin/profile'; ?>" aria-label="Profile" title="Profile">
                        <div class="float-start users-image" style="background-image:url(<?php print _BASE_PATH . 'media/item/thumb/' . $profile->users_image; ?>)"></div>
                    </a>
                    <?php else: ?>
                    <?php Button::link(_BASE_PATH . 'admin/profile',null,'feather/user.svg','Profile'); ?>
                    <?php endif;?>
                </li>
                <li>
                    <?php Button::link(_BASE_PATH . 'admin/logout',null,'feather/log-out.svg','Logout'); ?>
                </li>
            <?php else: ?>
                <li>
                    <?php Button::link(_BASE_PATH . 'admin/login',null,'feather/user.svg','Login'); ?>
                </li>
            <?php endif;?>
        </ul>
    </nav>
</header>
