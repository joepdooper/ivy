<input type="file" id="<?php echo isset($id)?$id:$name; ?>" class="d-none input-upload" name="<?php echo $name; ?>" accept="image/*,audio/*,video/*">
<label for="<?php echo isset($id)?$id:$name; ?>" class="button upload">
  <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/upload.svg"); ?>
</label>
