<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$documentation = (new \Documentation\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-documentation col-12 <?php if(!$item->parent): ?>col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $item->id; ?>">
	<div class="inner">

		<a class="item-wrap bg-secondary" href="<?php print _BASE_PATH . 'documentation/' . $item->id; ?>">
			<article>
				<div class="outer">
					<!-- Subject -->
					<div class="inner">
						<?php $tag = (new \Tag\Item)->where('id', $documentation->subject)->getRow()->data(); ?>
						<div class="tag">
							<?php print $tag->value; ?>
						</div>
					</div>
					<!-- Titles -->
					<div class="inner">
						<h1><?php print $documentation->title; ?></h1>
						<h2><?php print $documentation->subtitle; ?></h2>
					</div>
				</div>
			</article>
		</a>

		<?php if ($auth->isLoggedIn() && $item->author): ?>
			<form action="<?php print _BASE_PATH . 'documentation/update/' . $item->id; ?>" method="POST" enctype="multipart/form-data">
				<?php include $template->setTemplateFile('include/item_admin_buttons.php'); ?>
			</form>
		<?php endif; ?>

	</div>
</div>
