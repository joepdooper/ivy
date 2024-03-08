<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$article = (new \Article\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="<?php if(\Ivy\Template::$content->class): print \Ivy\Template::$content->class; else:?>item item-article col-12 col-md-6 col-lg-4<?php endif;?>" id="item-<?php print \Ivy\Template::$content->id; ?>">
	<div class="inner">

		<a class="item-wrap bg-secondary" href="<?php print _BASE_PATH . 'article/' . \Ivy\Template::$content->id; ?>">
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
						$author = (new \Ivy\Profile)->where('id',\Ivy\Template::$content->user_id)->getRow()->data();
						$date = \Ivy\Template::$content->date;
						include \Ivy\Template::setTemplateFile('include/author.php');
						?>
					</div>
				</div>
			</article>
		</a>

		<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
			<form action="<?php print _BASE_PATH . 'article/update/' . \Ivy\Template::$content->id; ?>" method="POST" enctype="multipart/form-data">
				<?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
			</form>
		<?php endif; ?>

	</div>
</div>
