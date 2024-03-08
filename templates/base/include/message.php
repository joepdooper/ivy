<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<input id="remove_flash_<?php echo $key; ?>" class="d-none input-remove-flash" type="checkbox" name="flash_<?php echo $key; ?>" checked>
<div class="flash_message inner">
	<div class="inner">
		<div class="flash_message_text"><strong><?php print $value; ?></strong></div>
		<div class="flash_message_close">
			<?php \Ivy\Button::remove('flash','flash_' . $key); ?>
		</div>
	</div>
</div>
