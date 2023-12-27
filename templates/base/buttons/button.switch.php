<input type="hidden" name="<?php echo $name; ?>" value="0" />
<input class="form-check-input visually-hidden" type="checkbox" role="switch" name="<?php echo $name; ?>" id="<?php echo isset($id)?$id:$name; ?>" value="1" <?php !$value ?: print "checked"; ?> >
<label class="switch" for="<?php echo isset($id)?$id:$name; ?>">
  <span class="slider"></span>
</label>
