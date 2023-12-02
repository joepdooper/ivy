<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$audio = (new Audio)->where('id', $item->table_id)->getRow()->data();
?>

<div class="item item-audio col-12 col-md-6 col-lg-4" id="item-<?php print $item->id; ?>">
	<div class="inner">

		<form action="<?php print _BASE_PATH . 'audio/update/' . $item->id . $page->url; ?>" method="POST" enctype="multipart/form-data">

			<div class="clmn">
				<?php if(!isset($audio->file)): ?>
					<div class="no-audio">no audio</div>
				<?php else: ?>
					<?php Audio::set('audio', _BASE_PATH . _MEDIA_PATH . 'item/audio/' . $audio->file); ?>
				<?php endif; ?>
				<?php if($item->author): ?>
					<div class="editImageButton">
						<?php if(!isset($audio->file)): ?>
							<?php $button->upload('upload_audio','single_audio_' . $item->id,'upload_audio_'.$item->id); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php include $page->setTemplateFile('content/item_admin_buttons.php'); ?>

		</form>

	</div>
</div>
