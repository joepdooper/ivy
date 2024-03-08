<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$audio = (new \Audio\Item)->where('id', \Ivy\Template::$content->table_id)->getRow()->data();
?>

<div class="item item-audio col-12 col-md-6 col-lg-4" id="item-<?php print \Ivy\Template::$content->id; ?>">
	<div class="inner">

		<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
			<form action="<?php print _BASE_PATH . 'audio/update/' . \Ivy\Template::$content->id . \Ivy\Template::$url; ?>" method="POST" enctype="multipart/form-data">
		<?php endif; ?>

			<div class="position-relative">
				<?php if(!isset($audio->file)): ?>
					<div class="no-audio">
						<div id="upload_audio_<?php print \Ivy\Template::$content->id; ?>Preview">no audio</div>
					</div>
				<?php else: ?>
					<?php \Audio\Item::set('audio', _BASE_PATH . _MEDIA_PATH . 'item/audio/' . $audio->file); ?>
				<?php endif; ?>
				<?php if ($auth->isLoggedIn() && \Ivy\Template::$content->author): ?>
					<div class="editImageButton">
						<?php if(!isset($audio->file)): ?>
							<?php \Ivy\Button::upload('upload_audio','single_audio_' . \Ivy\Template::$content->id,'upload_audio_'.\Ivy\Template::$content->id); ?>
							<script>
							window.addEventListener('DOMContentLoaded', (event) => {
								previewAudio("<?php print 'upload_audio_'.\Ivy\Template::$content->id; ?>","<?php print 'upload_audio_'.\Ivy\Template::$content->id; ?>Preview");
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
