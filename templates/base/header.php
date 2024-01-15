<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
if(isset($_SESSION['auth_user_id'])):
	$profile = (new \Ivy\Profile)->where('user_id',$_SESSION['auth_user_id'])->getRow()->data();
endif;
?>

<header id="header" class="bg-secondary position-relative">
	<?php if (isset($template->id)):?>
		<div class="float-start">
			<?php $button->link(_BASE_PATH,null,'feather/arrow-left.svg','Back'); ?>
		</div>
	<?php endif;?>
	<div class="float-start">
		<a id="logo" href="<?php echo _BASE_PATH;?>" title="<?php print $setting['name']->value; ?>">
			<?php print $setting['name']->value; ?>
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
					<?php if($profile->users_image): ?>
						<a href="<?php print _BASE_PATH . 'admin/profile'; ?>" aria-label="Profile" title="Profile">
							<div class="float-start users-image" style="background-image:url(<?php print _BASE_PATH . 'media/item/thumb/' . $profile->users_image; ?>)"></div>
						</a>
					<?php else: ?>
						<?php $button->link(_BASE_PATH . 'admin/profile',null,'feather/user.svg','Profile'); ?>
					<?php endif;?>
				</li>
				<li>
					<?php $button->link(_BASE_PATH . 'admin/logout',null,'feather/log-out.svg','Logout'); ?>
				</li>
			<?php else: ?>
				<li>
					<?php $button->link(_BASE_PATH . 'admin/login',null,'feather/user.svg','Login'); ?>
				</li>
			<?php endif;?>
		</ul>
	</nav>
</header>
