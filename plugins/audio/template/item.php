<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$audio = (new \Audio\Item)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-audio col-12 col-md-6 col-lg-4" id="item-<?php print $item->id; ?>">
	<div class="inner">

		<form action="<?php print _BASE_PATH . 'audio/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">

			<div class="position-relative">
				<?php if(!isset($audio->file)): ?>
					<div class="no-audio">
						<div id="upload_audio_<?php print $item->id; ?>Preview">no audio</div>
					</div>
				<?php else: ?>
					<?php \Audio\Item::set('audio', _BASE_PATH . _MEDIA_PATH . 'item/audio/' . $audio->file); ?>
				<?php endif; ?>
				<?php if($item->author): ?>
					<div class="editImageButton">
						<?php if(!isset($audio->file)): ?>
							<?php $button->upload('upload_audio','single_audio_' . $item->id,'upload_audio_'.$item->id); ?>
							<script>
							window.addEventListener('DOMContentLoaded', (event) => {
								previewAudio("<?php print 'upload_audio_'.$item->id; ?>","<?php print 'upload_audio_'.$item->id; ?>Preview");
							});
							</script>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php include $page->setTemplateFile('buttons/item_admin_buttons.php'); ?>

		</form>

	</div>
</div>
