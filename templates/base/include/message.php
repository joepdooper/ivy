<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');

use Ivy\Button;
use Ivy\Template;

$message = Template::$content;
?>

<input id="remove_flash_<?php echo $message->id; ?>" class="d-none input-remove-flash" type="checkbox" name="flash_<?php echo $message->id; ?>" checked>
<div class="flash_message inner">
	<div class="inner">
		<div class="flash_message_text"><strong><?php print $message->text; ?></strong></div>
		<div class="flash_message_close">
			<?php Button::remove('flash','flash_' . $message->id); ?>
		</div>
	</div>
</div>
