<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$article = (new Article)->where('id', $item->table_id)->getRow()->data();
?>

<div class="article">
	<article>

		<?php if ($item->author): ?>
			<form action="<?php print _BASE_PATH . 'article/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">
			<?php endif; ?>

			<div class="outer">

				<?php if ($item->author): ?>
					<div class="inner">
						<?php $button->switch('publish_item', $item->published); ?>
						<label class="switch-txt" for="publish_item">publish</label>
					</div>
				<?php endif; ?>

				<?php if(isset($article->subject)): ?>
					<!-- Subject -->
					<div class="inner">
						<?php $tag = (new Tag)->where('id', $article->subject)->getRow()->data();?>
						<?php include _PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'tag/template/tag.php'); ?>
					</div>
				<?php endif; ?>

				<!-- Titles -->
				<div class="inner">
					<h1><?php $item->author ? Text::set('title',$article->title,'title') : print $article->title; ?></h1>
					<h2><?php $item->author ? Text::set('subtitle',$article->subtitle,'subtitle') : print $article->subtitle; ?></h2>
				</div>

				<!-- Author -->
				<div class="inner">
					<?php
					$author = (new \Ivy\Profile)->where('id',$item->user_id)->getRow()->data(); 
					$date = $item->date;
					?>
					<?php if($item->author): ?>
						<?php $page->setDateTime('datetime',date('Y-m-d H:i:s',strtotime($date))); ?>
					<?php else: ?>
						<?php include $page->setTemplateFile('content/author.php'); ?>
					<?php endif; ?>
				</div>

			</div>

			<!-- Main image -->
			<div class="main-image">
				<?php Image::set('image', $article->image); ?>
				<?php if($item->author): ?>
					<?php if(!$article->image): ?>
						<div class="no-image">
							<img id="upload_image_<?php print $item->table_id; ?>Preview" src="#" alt="no image" />
						</div>
					<?php endif; ?>
					<div class="editImageButton">
						<?php if($article->image): ?>
							<?php $button->delete('delete_image','main_article_image_' . $item->id, 'delete_image_' . $item->table_id); ?>
						<?php else: ?>
							<?php $button->upload('upload_image','main_article_image_' . $item->id, 'upload_image_' . $item->table_id); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if($item->author): ?>
				<div class="inner text-align-center">
					<?php $button->submit('save'); ?>
				</div>
			</form>
		<?php endif; ?>

		<div class="outer">
			<?php $items = (new \Ivy\Item)->where('parent',$item->id)->orderBy('id','asc')->get()->data();?>
			<?php if($items): ?>
				<?php foreach($items as $item):?>
					<?php if($item->published || $item->author): ?>
						<?php include _PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . $item->plugin . '/template/' . $item->item_template_file); ?>
					<?php endif; ?>
				<?php endforeach;?>
			<?php endif; ?>
		</div>

		<?php include $page->setTemplateFile('content/add.php'); ?>

	</article>
</div>
