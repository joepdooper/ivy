<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$article = (new \Article\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="<?php if($item->class): print $item->class; else:?>item item-article col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $item->id; ?>">
	<div class="inner">

		<a class="item-wrap bg-secondary" href="<?php print _BASE_PATH . 'article/' . $item->id; ?>">
			<?php if(!empty($article->image)): ?>
				<?php \Image\Item::set('image', $article->image); ?>
			<?php endif; ?>
			<article>
				<div class="outer">
					<!-- Subject -->
					<div class="inner">
						<?php $tag = (new \Tag\Item)->where('id', $article->subject)->getRow()->data(); ?>
						<div class="tag">
							<?php print $tag->value; ?>
						</div>
					</div>
					<!-- Titles -->
					<div class="inner">
						<h1><?php print $article->title; ?></h1>
						<h2><?php print $article->subtitle; ?></h2>
					</div>
					<!-- Author -->
					<div class="inner">
						<?php
						$author = (new \Ivy\Profile)->where('id',$item->user_id)->getRow()->data();
						$date = $item->date;
						include $template->setTemplateFile('include/author.php');
						?>
					</div>
				</div>
			</article>
		</a>

		<?php if ($auth->isLoggedIn() && $item->author): ?>
			<form action="<?php print _BASE_PATH . 'article/update/' . $item->id; ?>" method="POST" enctype="multipart/form-data">
				<?php include $template->setTemplateFile('buttons/item_admin_buttons.php'); ?>
			</form>
		<?php endif; ?>

	</div>
</div>
