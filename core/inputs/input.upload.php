<input type="file" id="<?php echo isset($id)?$id:$name; ?>" class="visually-hidden input-upload" name="<?php echo $name; ?>" accept="image/*,audio/*,video/*">

<script>
window.addEventListener('DOMContentLoaded', (event) => {
  previewImage("<?php echo isset($id)?$id:$name; ?>","<?php print isset($id)?$id:$name; ?>Preview","src");
});
</script>
