<?php if(!empty($value)): ?>

<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">

<?php
$image_info = getimagesize(_BASE_PATH . "media/item/thumb/" . $value);
$image_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
?>

<picture>
  <source media="(min-width:1024px)" srcset="<?php print _SUBFOLDER; ?>media/item/large/<?php print $image_name . '.webp'; ?> 1x, <?php print _SUBFOLDER; ?>media/item/large/<?php print $image_name . '.webp'; ?> 2x" type="image/webp">
  <source media="(min-width:1024px)" srcset="<?php print _SUBFOLDER; ?>media/item/large/<?php print $value; ?> 1x, <?php print _SUBFOLDER; ?>media/item/large/<?php print $value; ?> 2x">
  <source media="(min-width:660px)" srcset="<?php print _SUBFOLDER; ?>media/item/small/<?php print $image_name . '.webp'; ?> 1x, <?php print _SUBFOLDER; ?>media/item/large/<?php print $image_name . '.webp'; ?> 2x" type="image/webp">
  <source media="(min-width:660px)" srcset="<?php print _SUBFOLDER; ?>media/item/small/<?php print $value; ?> 1x, <?php print _SUBFOLDER; ?>media/item/large/<?php print $value; ?> 2x">
  <source media="(min-width:320px)" srcset="<?php print _SUBFOLDER; ?>media/item/thumb/<?php print $image_name . '.webp'; ?> 1x, <?php print _SUBFOLDER; ?>media/item/small/<?php print $image_name . '.webp'; ?> 2x" type="image/webp">
  <source media="(min-width:320px)" srcset="<?php print _SUBFOLDER; ?>media/item/thumb/<?php print $value; ?> 1x, <?php print _SUBFOLDER; ?>media/item/small/<?php print $value; ?> 2x">
  <img src="<?php print _SUBFOLDER; ?>media/item/thumb/<?php print $value; ?>" <?php print $image_info[3]; ?> alt="" loading="lazy">
</picture>

<?php endif; ?>
