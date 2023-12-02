<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
if (in_array("Overlay mode", $_SESSION['plugins_active'])):
	(new Overlay)->set('loading-mode',$page->setTemplateFile('content/loader.php'));
endif;
?>

<?php if(canEditAsAdmin($auth)): ?>
	<footer>
		<nav class="menu">
			<ul>
				<!-- <li>
					<?php $button->link(_BASE_PATH . 'plugin/mailer',null,'feather/send.svg','Mailer'); ?>
				</li> -->
				<!-- <li>
					<?php $button->link(_BASE_PATH . 'admin/media',null,'feather/folder.svg','Media'); ?>
				</li> -->
				<li>
					<?php $button->link(_BASE_PATH . 'admin/info',null,'feather/info.svg','Infos'); ?>
				</li>
				<li>
					<?php $button->link(_BASE_PATH . 'admin/option',null,'feather/sliders.svg','Options'); ?>
				</li>
				<li>
					<?php $button->link(_BASE_PATH . 'admin/template',null,'feather/layout.svg','Templates'); ?>
				</li>
				<li>
					<?php $button->link(_BASE_PATH . 'admin/plugin',null,'feather/package.svg','Plugins'); ?>
				</li>
				<li>
					<?php $button->link(_BASE_PATH . 'admin/user',null,'feather/users.svg','Users'); ?>
				</li>
				<?php if (in_array("Tag", $_SESSION['plugins_active'])):?>
				<li>
					<?php $button->link(_BASE_PATH . 'plugin/tag',null,'feather/tag.svg','Tags'); ?>
				</li>
				<?php endif;?>
			</ul>
		</nav>
	</footer>
<?php endif; ?>

<?php
function add_footer_js(){
	global $page;
	$page->addJS("templates/base/js/helper.js");
	$page->addJS("node_modules/axios/dist/axios.min.js");
	$page->addJS("node_modules/sortablejs/Sortable.min.js");
	$page->addJS("node_modules/linkifyjs/dist/linkify.min.js");
	$page->addJS("node_modules/linkify-html/dist/linkify-html.min.js");
}

$hooks->add_action('add_js_action','add_footer_js','1');
?>
