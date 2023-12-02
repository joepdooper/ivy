<a class="button" href="<?php !$url ?: print $url; ?>" aria-label="<?php !$label ?: print $label; ?>" title="<?php !$label ?: print $label; ?>">
  <?php !$text ?: print $text; ?>
  <?php !$icon ?: print file_get_contents(_PUBLIC_PATH . "media/icon/" . $icon); ?>
</a>
