<?php
$itemtemplates = (new \Ivy\ItemTemplate)->get()->data();
?>

<?php if($itemtemplates):?>
	<ul class="itemlist">
		<?php foreach($itemtemplates as $itemtemplate):?>
			<?php $plugin = (new \Ivy\Plugin)->where('url',$itemtemplate->plugin_url)->getRow()->data(); ?>
			<?php if($plugin->active): ?>
				<li>
					<form action="<?php print _BASE_PATH . $itemtemplate->route . '/insert/' . $itemtemplate->id;(!isset($template->id) && empty($template->id)) ?: print '/' . $template->route . '/' . $template->id; ?>" method="POST" enctype="multipart/form-data">
						<?php $button->submit($itemtemplate->name); ?>
					</form>
				</li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
<?php endif;?>
