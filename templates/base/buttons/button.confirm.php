<button class="button confirm" type="submit" name="submit" value="<?php print $value; ?>" <?php if(isset($formaction)):?>formaction="<?php print $formaction; ?>"<?php endif; ?>>
  <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/check.svg"); ?>
</button>
