<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Button;
use Ivy\Template;
global $auth;
$content = Template::$content;
$content->data = (new \Image\Item)->where('id', Template::$content->table_id)->getRow()->data();
?>

<div class="item item-image col-12 col-md-6 col-lg-4" id="item-<?php print Template::$content->id; ?>">
	<div class="inner">

		<?php if ($auth->isLoggedIn() && Template::$content->author): ?>
			<form action="<?php print _BASE_PATH . 'image/update/' . Template::$content->id . Template::$url; ?>" method="POST" enctype="multipart/form-data">
		<?php endif; ?>

			<div class="position-relative">
				<?php if(!$content->data->file): ?>
					<div class="no-image">
						<img id="upload_image_<?php print Template::$content->id; ?>Preview" src="#" alt="no image" />
					</div>
				<?php else: ?>
					<?php \Image\Item::set('image',$content->data->file); ?>
				<?php endif; ?>

				<?php if ($auth->isLoggedIn() && Template::$content->author): ?>
					<div class="editImageButton">
						<?php if($content->data->file): ?>
							<?php Button::delete('delete_image','single_image_' . Template::$content->id,'delete_image_'. Template::$content->id); ?>
						<?php else: ?>
							<?php Button::upload('upload_image','single_image_' . Template::$content->id,'upload_image_'. Template::$content->id); ?>
							<script>
							window.addEventListener('DOMContentLoaded', () => {
								previewImage("<?php print 'upload_image_'. Template::$content->id; ?>","<?php print 'upload_image_'. Template::$content->id; ?>Preview","src");
							});
							</script>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		<?php if ($auth->isLoggedIn() && Template::$content->author): ?>
			<?php include Template::file('include/item_admin_buttons.php'); ?>
			</form>
		<?php endif; ?>

	</div>
</div>
