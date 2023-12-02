<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

if(isset($_SESSION['auth_user_id'])):
	$profile = new \Ivy\Profile($_SESSION['auth_user_id']);
endif;
?>

<header id="header">
	<?php if (isset($page->id)):?>
		<div class="return">
			<?php $button->link(_BASE_PATH,null,'feather/arrow-left.svg','Back'); ?>
		</div>
	<?php endif;?>
	<div class="logo">
		<a id="logo" href="<?php echo _BASE_PATH;?>" title="<?php print $info['name']->value; ?>">
			<?php print $info['name']->value; ?>
		</a>
	</div>
	<label class="dark-mode-label" for="dark-mode" title="Toggle light/dark mode">
		<?php
		echo file_get_contents(_BASE_PATH . 'media/icon/' . "feather/sun.svg");
		echo file_get_contents(_BASE_PATH . 'media/icon/' . "feather/moon.svg");
		?>
	</label>
	<nav class="menu" id="main">
		<ul class="clearfix">
			<?php if($auth->isLoggedIn()): ?>
				<li>
					<?php if($profile->image): ?>
						<a href="<?php print _BASE_PATH . 'admin/profile'; ?>" aria-label="Profile" title="Profile">
							<div class="users-image" style="background-image:url(<?php print _BASE_PATH . 'media/item/thumb/' . $profile->image; ?>)"></div>
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
