<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
$items = Template::$content;
?>

<?php if($items): ?>
	<div class="inner">
		<div id="grid" class="row">
			<?php foreach($items as $item):?>
				<?php if($item->published || $item->author): ?>
					<?php include Template::file(_PLUGIN_PATH . $item->plugin_url . '/template/' . $item->file, $item); ?>
				<?php endif; ?>
			<?php endforeach;?>
		</div>
	</div>
<?php endif; ?>
