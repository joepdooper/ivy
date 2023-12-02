<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
?>

<div class="loading">
	<div class="outer">

		<div class="inner">
			<?php include isset($this->content) ? $this->content : $content; ?>
		</div>

	</div>
</div>
