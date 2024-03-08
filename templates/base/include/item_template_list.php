<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$itemtemplates = (new \Ivy\ItemTemplate)->get()->data();
?>

<?php if($itemtemplates):?>
	<ul class="itemlist">
		<?php foreach($itemtemplates as $itemtemplate):?>
			<?php $plugin = (new \Ivy\Plugin)->where('url',$itemtemplate->plugin_url)->getRow()->data(); ?>
				<?php if(isset($plugin->active) && $plugin->active): ?>
					<li>
						<form action="<?php print _BASE_PATH . $itemtemplate->route . '/insert/' . $itemtemplate->id;(!isset(\Ivy\Template::$id) && empty(\Ivy\Template::$id)) ?: print '/' . \Ivy\Template::$route . '/' . \Ivy\Template::$id; ?>" method="POST" enctype="multipart/form-data">
							<?php \Ivy\Button::submit($itemtemplate->name); ?>
						</form>
					</li>
				<?php endif;?>
		<?php endforeach;?>
	</ul>
<?php endif;?>
