<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<?php if(canEditAsEditor($auth)): ?>

	<input id="overlay-mode" name="overlay-mode" class="overlay-mode-checkbox d-none" type="checkbox">

	<label class="overlay" for="overlay-mode">
		<div class="popup">
			<div class="outer">
				<div class="inner">
					<?php (new \Ivy\Button)->close('close',"overlay-mode"); ?>
					<?php include $template->setTemplateFile('include/item_template_list.php'); ?>
				</div>
			</div>
		</div>
	</label>

<?php endif; ?>
