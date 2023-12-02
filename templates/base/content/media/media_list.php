<ul>

	<?php foreach($dir as $key => $val):?>
		<li>

			<input type="radio" class="medialistcheckbox visually-hidden" id="<?php print $val['path'] . "_SUFFIX"; ?>" value="<?php print $val['path']; ?>" name="select" <?php !$val['active'] ?: print 'checked'; ?>>

			<label class="previous" for="<?php print $prev . "_SUFFIX"; ?>">
				<div class="icon">
					<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/chevron-left.svg");?>
				</div>
				<div class="text">
					<strong>
						<?php (basename($prev) == 'upload') ?: print basename($prev);?>
					</strong>
				</div>
			</label>

			<div class="<?php print $val['type'];?> parent" <?php if($val['type'] == 'file'): ?>  data-link="<?php print $val['path']; ?>" data-type="<?php print $val['filetype']; ?>"<?php endif;?>>
				<label class="definition" for="<?php print $val['path'] . "_SUFFIX"; ?>">
					<div class="icon">

						<?php if($val['type'] == 'dir'): ?>
							<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/folder.svg"); ?>
						<?php endif;?>

						<?php if($val['type'] == 'file'): ?>
							<?php if($val['filetype'] == "image"):?>
								<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/image.svg"); ?>
							<?php elseif($val['filetype'] == "audio"):?>
								<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/music.svg"); ?>
							<?php elseif($val['filetype'] == "video"):?>
								<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/video.svg"); ?>
							<?php else:?>
								<?php echo file_get_contents(_PUBLIC_PATH . 'media/icon/' . "feather/file.svg"); ?>
							<?php endif;?>
						<?php endif;?>

					</div>

					<div class="text">
						<strong>
							<?php print $val['name'];?>
							<?php if($val['type'] == 'file'): ?>
								<?php print '.' . $val['extension']; ?>
							<?php endif;?>
						</strong>
					</div>

					<?php if($val['type'] == 'file'): ?>
						<div class="info">
							<?php print $val['date']; ?> -
							<?php print $val['size']; ?>
						</div>
					<?php endif;?>

				</label>
			</div>

			<?php if($val['type'] == 'dir'): ?>
				<?php $this->getFileStructure($val['path'],$level); ?>
			<?php endif;?>

		</li>
	<?php endforeach;?>

</ul>
