<?php if(canEditArticle($auth)): ?>

	<?php
	if (in_array("Overlay mode", $_SESSION['plugins_active'])) {
		(new Overlay)->popup('overlay-mode',$page->setTemplateFile('content/item_template_list.php'));
	}
	?>

	<div class="outer text-align-center">
		<label for="overlay-mode" class="button">
			<?php print file_get_contents(_PUBLIC_PATH . "/media/icon/" . "feather/plus.svg"); ?>
		</label>
	</div>

<?php endif; ?>
