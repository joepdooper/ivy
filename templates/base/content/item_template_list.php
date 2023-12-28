<?php
$templates = (new \Ivy\ItemTemplate)->get()->data();
?>
<?php if($templates):?>
	<ul class="itemlist">
		<?php foreach($templates as $template):?>
			<?php $plugin = (new \Ivy\Plugin)->where('folder',$template->plugin)->getRow()->data(); ?>
			<?php if($plugin->active): ?>
				<li>
					<form action="<?php print _BASE_PATH . $template->plugin . '/insert/' . $template->id;(!isset($page->id) && empty($page->id)) ?: print '/' . $page->route . '/' . $page->id; ?>" method="POST" enctype="multipart/form-data">
						<?php $button->submit($template->name); ?>
					</form>
				</li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
<?php endif;?>
