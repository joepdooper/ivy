<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$article = (new \Article\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="article">
	<article>

		<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
			<form action="<?php print _BASE_PATH . 'article/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
			<?php endif; ?>

			<div class="outer">

				<?php if(isset($article->subject)): ?>
					<!-- Subject -->
					<div class="inner">
						<?php $tag = (new \Tag\Item)->where('id', $article->subject)->getRow()->data();?>
						<?php include _PUBLIC_PATH . \Ivy\Template::setTemplateFile(_PLUGIN_PATH . 'Tag/template/tag.php'); ?>
					</div>
				<?php endif; ?>

				<!-- Titles -->
				<div class="inner">
					<h1><?php $auth->isLoggedIn() && \Ivy\Template::$content->author ? \Text\Item::set('title',$article->title,'title') : print $article->title; ?></h1>
					<h2><?php $auth->isLoggedIn() && \Ivy\Template::$content->author ? \Text\Item::set('subtitle',$article->subtitle,'subtitle') : print $article->subtitle; ?></h2>
				</div>

				<!-- Author -->
				<div class="inner">
					<?php
					$author = (new \Ivy\Profile)->where('id',\Ivy\Template::$content->user_id)->getRow()->data();
					$date = \Ivy\Template::$content->date;
					?>
					<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
                        <label for="datetime_<?php echo \Ivy\Template::$content->id; ?>"></label>
                        <input class="editor form-control" type="datetime-local" id="datetime_<?php echo \Ivy\Template::$content->id; ?>" name="datetime" value="<?php echo date('Y-m-d H:i:s',strtotime($date)); ?>">
					<?php else: ?>
						<?php include \Ivy\Template::setTemplateFile('include/author.php'); ?>
					<?php endif; ?>
				</div>

			</div>

			<!-- Main image -->
			<div class="main-image">
				<?php if(!$article->image && \Ivy\Template::$content->author): ?>
					<div class="no-image">
						<img id="upload_image_<?php print \Ivy\Template::$content->table_id; ?>Preview" src="#" alt="no image" />
					</div>
				<?php else: ?>
					<?php \Image\Item::set('image', $article->image); ?>
				<?php endif; ?>
				<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
					<div class="editImageButton">
						<?php if($article->image): ?>
							<?php \Ivy\Button::delete('delete_image','main_article_image_' . \Ivy\Template::$content->id, 'delete_image_' . \Ivy\Template::$content->table_id); ?>
						<?php else: ?>
							<?php \Ivy\Button::upload('upload_image','main_article_image_' . \Ivy\Template::$content->id, 'upload_image_' . \Ivy\Template::$content->table_id); ?>
							<script>
							window.addEventListener('DOMContentLoaded', (event) => {
								previewImage("<?php print 'upload_image_' . \Ivy\Template::$content->table_id; ?>","<?php print 'upload_image_' . \Ivy\Template::$content->table_id; ?>Preview","src");
							});
							</script>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
				<div class="outer">
					<div class="inner">
						<?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
					</div>
				</div>
			</form>
		<?php endif; ?>

		<div class="outer">
			<?php $items = (new \Ivy\Item)->where('parent',\Ivy\Template::$content->id)->orderBy(['sort', 'date', 'id'],'asc')->get()->data(); ?>
			<?php if($items): ?>
				<?php foreach($items as $item):?>
					<?php if($item->published || $item->author): ?>
						<?php include _PUBLIC_PATH . \Ivy\Template::setTemplateFile(_PLUGIN_PATH . $item->plugin_url. '/template/' . $item->file, $item); ?>
					<?php endif; ?>
				<?php endforeach;?>
			<?php endif; ?>
		</div>

	</article>
</div>
