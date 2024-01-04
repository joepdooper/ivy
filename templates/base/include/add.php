<?php if(canEditAsEditor($auth)): ?>

	<input id="overlay-mode" name="overlay-mode" class="overlay-mode-checkbox d-none" type="checkbox">

	<label class="overlay" for="overlay-mode">
		<div class="popup">
			<div class="outer">
				<div class="inner">
					<?php
					(new \Ivy\Button)->close('close',"overlay-mode");
					?>
					<?php include $page->setTemplateFile('include/item_template_list.php'); ?>
				</div>
			</div>
		</div>
	</label>

	<div class="outer text-align-center">
		<label for="overlay-mode" class="button">
			<?php print file_get_contents(_PUBLIC_PATH . "/media/icon/" . "feather/plus.svg"); ?>
		</label>
	</div>

<?php endif; ?>
