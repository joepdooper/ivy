<input id="<?php echo isset($id)?$id:$name; ?>" class="d-none input-delete" type="checkbox" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
<label for="<?php echo isset($id)?$id:$name; ?>" class="button delete">
  <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/trash-2.svg"); ?>
</label>
