<input type="hidden" name="<?php echo $name; ?>" value="0" />
<input id="<?php echo isset($id)?$id:$name; ?>" class="checkbox visually-hidden" type="checkbox" name="<?php echo $name; ?>" value="1" <?php !$value ?: print 'checked'; ?>>
