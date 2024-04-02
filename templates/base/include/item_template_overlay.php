<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Button;
use Ivy\Template;
use Ivy\User;
global $auth;
?>

<?php if(User::canEditAsEditor($auth)): ?>
	<input id="overlay-mode" name="overlay-mode" class="overlay-mode-checkbox d-none" type="checkbox">
	<label class="overlay" for="overlay-mode">
		<div class="popup">
			<div class="outer">
				<div class="inner">
					<?php Button::close('close',"overlay-mode"); ?>
					<?php include Template::file('include/item_template_list.php', (new ItemTemplate)->get()->data()); ?>
				</div>
			</div>
		</div>
	</label>
<?php endif; ?>
