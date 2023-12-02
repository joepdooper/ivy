<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$items = (new \Ivy\Item)->where('parent',null)->orderBy('id','desc')->get()->data();
?>

<?php if($items): ?>

	<div class="inner">
		<div id="grid" class="row">

			<?php foreach($items as $item):?>

				<?php if($item->published || $item->author): ?>
					<?php include $page->setTemplateFile(_PLUGIN_PATH . $item->plugin . '/template/' . $item->item_template_file); ?>
				<?php endif; ?>

			<?php endforeach;?>

		</div>
	</div>

<?php endif; ?>
