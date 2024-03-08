<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
?>

<?php if(\Ivy\User::canEditAsEditor($auth)): ?>

	<input id="overlay-mode" name="overlay-mode" class="overlay-mode-checkbox d-none" type="checkbox">

	<label class="overlay" for="overlay-mode">
		<div class="popup">
			<div class="outer">
				<div class="inner">
					<?php \Ivy\Button::close('close',"overlay-mode"); ?>
					<?php include \Ivy\Template::setTemplateFile('include/item_template_list.php'); ?>
				</div>
			</div>
		</div>
	</label>

<?php endif; ?>
