<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$button = new \Ivy\Button();
?>

<div class="popup">
	<div class="outer">

		<div class="inner">
			<?php
			$button->close('close',isset($this->for) ? $this->for : $for);
			?>

			<?php include isset($this->content) ? $this->content : $content; ?>
		</div>

	</div>
</div>
