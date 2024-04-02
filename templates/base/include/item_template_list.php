<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Button;
use Ivy\Plugin;
use Ivy\Template;
?>

<?php if(Template::$content):?>
	<ul class="itemlist">
		<?php foreach(Template::$content as $item_template):?>
			<?php $plugin = (new Plugin)->where('url',$item_template->plugin_url)->getRow()->data(); ?>
				<?php if(isset($plugin->active) && $plugin->active): ?>
					<li>
						<form action="<?php print _BASE_PATH . $item_template->route . '/insert/' . $item_template->id;(!isset(Template::$id) && empty(Template::$id)) ?: print '/' . Template::$route . '/' . Template::$id; ?>" method="POST" enctype="multipart/form-data">
							<?php Button::submit($item_template->name); ?>
						</form>
					</li>
				<?php endif;?>
		<?php endforeach;?>
	</ul>
<?php endif;?>
