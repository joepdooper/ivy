<span class="editButtons">

  <label for="delete<?php echo $id; ?>" class="button delete">
    <?php print file_get_contents("media/icon/feather/trash-2.svg"); ?>
  </label>

  <label for="upload<?php echo $key; ?>" class="button upload">
    <?php print file_get_contents("media/icon/feather/upload.svg"); ?>
  </label>

  <button class="button confirm" type="submit" value="Delete article"><?php print file_get_contents("media/icon/feather/check.svg"); ?></button>

  <input id="article<?php echo $this->id; ?>" type="checkbox" name="posts[]" class="delete_article" value="<?php echo $this->id; ?>">
  <input type="file" id="upload<?php echo $key; ?>" name="longcopy[<?php echo $key; ?>]" accept="image/*" class="imageinput">

</span>
