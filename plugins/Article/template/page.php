<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Button;
use Ivy\Item;
use Ivy\Profile;
use Ivy\Template;
global $auth;
$article = Template::$content;
?>

<div class="article">
	<article>

		<?php if ($auth->isLoggedIn() && $article->author): ?>
			<form action="<?php print _BASE_PATH . 'article/update/' . $article->id . Template::$url; ?>" method="POST" enctype="multipart/form-data">
			<?php endif; ?>

			<div class="outer">

				<?php if(isset($article->data->subject)): ?>
					<!-- Subject -->
					<div class="inner">
						<?php $tag = (new \Tag\Item)->where('id', $article->data->subject)->getRow()->data();?>
						<?php include _PUBLIC_PATH . Template::file(_PLUGIN_PATH . 'Tag/template/tag.php'); ?>
					</div>
				<?php endif; ?>

				<!-- Titles -->
				<div class="inner">
					<h1><?php $auth->isLoggedIn() && $article->author ? \Text\Item::set('title', $article->data->title,'title') : print $article->data->title; ?></h1>
					<h2><?php $auth->isLoggedIn() && $article->author ? \Text\Item::set('subtitle', $article->data->subtitle,'subtitle') : print $article->data->subtitle; ?></h2>
				</div>

				<!-- Author -->
				<div class="inner">
					<?php if ($auth->isLoggedIn() && $article->author): ?>
                        <label for="datetime_<?php echo $article->id; ?>"></label>
                        <input class="editor form-control" type="datetime-local" id="datetime_<?php echo $article->id; ?>" name="datetime" value="<?php echo date('Y-m-d H:i:s',strtotime($article->date)); ?>">
					<?php else: ?>
						<?php
                        $author = (new Profile)->where('id', $article->user_id)->getRow()->data();
                        $author->date = $article->date;
                        include Template::file('include/author.php', $author);
                        ?>
					<?php endif; ?>
				</div>

			</div>

			<!-- Main image -->
			<div class="main-image">
				<?php if(!$article->data->image && $article->author): ?>
					<div class="no-image">
						<img id="upload_image_<?php print $article->table_id; ?>Preview" src="#" alt="no image" />
					</div>
				<?php else: ?>
					<?php \Image\Item::set('image', $article->data->image); ?>
				<?php endif; ?>
				<?php if ($auth->isLoggedIn() && $article->author): ?>
					<div class="editImageButton">
						<?php if($article->data->image): ?>
							<?php Button::delete('delete_image','main_article_image_' . $article->id, 'delete_image_' . $article->table_id); ?>
						<?php else: ?>
							<?php Button::upload('upload_image','main_article_image_' . $article->id, 'upload_image_' . $article->table_id); ?>
							<script>
							window.addEventListener('DOMContentLoaded', (event) => {
								previewImage("<?php print 'upload_image_' . $article->table_id; ?>","<?php print 'upload_image_' . $article->table_id; ?>Preview","src");
							});
							</script>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ($auth->isLoggedIn() && $article->author): ?>
				<div class="outer">
					<div class="inner">
						<?php include Template::file('include/item_admin_buttons.php'); ?>
					</div>
				</div>
			</form>
		<?php endif; ?>

		<div class="outer">
			<?php $items = (new Item)->where('parent', $article->id)->orderBy(['sort', 'date', 'id'],'asc')->get()->data(); ?>
			<?php if($items): ?>
				<?php foreach($items as $item):?>
					<?php if($item->published || $item->author): ?>
						<?php include _PUBLIC_PATH . Template::file(_PLUGIN_PATH . $item->plugin_url. '/template/' . $item->file, $item); ?>
					<?php endif; ?>
				<?php endforeach;?>
			<?php endif; ?>
		</div>

	</article>
</div>
