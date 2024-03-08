<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$documentation = (new \Documentation\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="item item-documentation col-12 <?php if(!\Ivy\Template::$content->parent): ?>col-md-6 col-lg-4<?php endif;?>" id="item-<?php print \Ivy\Template::$content->id; ?>">
	<div class="inner">

		<a class="item-wrap bg-secondary" href="<?php print _BASE_PATH . 'documentation/' . \Ivy\Template::$content->id; ?>">
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

		<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
			<form action="<?php print _BASE_PATH . 'documentation/update/' . \Ivy\Template::$content->id; ?>" method="POST" enctype="multipart/form-data">
				<?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
			</form>
		<?php endif; ?>

	</div>
</div>
