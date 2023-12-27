<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$docs = (new Docs)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-docs col-12 <?php if(!$item->parent): ?>col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $item->id; ?>">
	<div class="inner">
		<a class="item-wrap" href="<?php print _BASE_PATH . 'docs/' . $item->id; ?>">

			<div class="clmn">
				<article>
					<div class="outer">
						<!-- Subject -->
						<div class="inner">
							<?php $tag = (new Tag)->where('id', $docs->subject)->getRow()->data(); ?>
							<div class="tag">
								<?php print $tag->value; ?>
							</div>
						</div>
						<!-- Titles -->
						<div class="inner">
							<h1><?php print $docs->title; ?></h1>
							<h2><?php print $docs->subtitle; ?></h2>
						</div>
					</div>
				</article>
			</div>

		</a>

		<form action="<?php print _BASE_PATH . 'docs/update/' . $item->id; ?>" method="POST" enctype="multipart/form-data">
			<?php
			if ($auth->isLoggedIn()):
				include $page->setTemplateFile('buttons/item_admin_buttons.php');
			endif;
			?>
		</form>

	</div>
</div>
