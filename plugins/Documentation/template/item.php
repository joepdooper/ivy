<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
global $auth;
$content = Template::$content;
$content->data = (new \Documentation\Item)->where('id', $content->table_id)->getRow()->data();
?>

<div class="item item-documentation col-12 <?php if(!$content->parent): ?>col-md-6 col-lg-4<?php endif;?>" id="item-<?php print $content->id; ?>">
	<div class="inner">

		<a class="item-wrap bg-secondary" href="<?php print _BASE_PATH . 'documentation/' . $content->id; ?>">
			<article>
				<div class="outer">
					<!-- Subject -->
					<div class="inner">
						<?php $tag = (new \Tag\Item)->where('id', $content->data->subject)->getRow()->data(); ?>
						<div class="tag">
							<?php print $tag->value; ?>
						</div>
					</div>
					<!-- Titles -->
					<div class="inner">
						<h1><?php print $content->data->title; ?></h1>
						<h2><?php print $content->data->subtitle; ?></h2>
					</div>
				</div>
			</article>
		</a>

		<?php if ($auth->isLoggedIn() && $content->author): ?>
			<form action="<?php print _BASE_PATH . 'documentation/update/' . $content->id; ?>" method="POST" enctype="multipart/form-data">
				<?php include Template::file('include/item_admin_buttons.php'); ?>
			</form>
		<?php endif; ?>

	</div>
</div>
