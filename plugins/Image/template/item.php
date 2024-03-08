<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$image = (new \Image\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="item item-image col-12 col-md-6 col-lg-4" id="item-<?php print \Ivy\Template::$content->id; ?>">
	<div class="inner">

		<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
			<form action="<?php print _BASE_PATH . 'image/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
		<?php endif; ?>

			<div class="position-relative">
				<?php if(!$image->file): ?>
					<div class="no-image">
						<img id="upload_image_<?php print \Ivy\Template::$content->id; ?>Preview" src="#" alt="no image" />
					</div>
				<?php else: ?>
					<?php \Image\Item::set('image',$image->file); ?>
				<?php endif; ?>

				<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
					<div class="editImageButton">
						<?php if($image->file): ?>
							<?php \Ivy\Button::delete('delete_image','single_image_' . \Ivy\Template::$content->id,'delete_image_'.\Ivy\Template::$content->id); ?>
						<?php else: ?>
							<?php \Ivy\Button::upload('upload_image','single_image_' . \Ivy\Template::$content->id,'upload_image_'.\Ivy\Template::$content->id); ?>
							<script>
							window.addEventListener('DOMContentLoaded', () => {
								previewImage("<?php print 'upload_image_'.\Ivy\Template::$content->id; ?>","<?php print 'upload_image_'.\Ivy\Template::$content->id; ?>Preview","src");
							});
							</script>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
			<?php include \Ivy\Template::setTemplateFile('include/item_admin_buttons.php'); ?>
			</form>
		<?php endif; ?>

	</div>
</div>
