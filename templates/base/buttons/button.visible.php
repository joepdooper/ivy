<input type="hidden" name="<?php echo $name; ?>" value="0" />
<input id="<?php echo isset($id)?$id:$name; ?>" class="checkbox visually-hidden" type="checkbox" name="<?php echo $name; ?>" value="1" <?php !$value ?: print 'checked'; ?>>
<label class="button visible" for="<?php echo $id; ?>">
  <?php echo file_get_contents(_BASE_PATH . 'media/icon/' . "feather/eye.svg"); ?><?php echo file_get_contents(_BASE_PATH . 'media/icon/' . "feather/eye-off.svg"); ?>
</label>
