<input type="hidden" id="input<?php echo $id; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>">

<div id="editor<?php echo $id; ?>" class="editor">
  <div id="content<?php echo $id; ?>" class="content" contenteditable="true">
    <?php echo $value; ?>
  </div>
</div>

<script>
window.addEventListener('DOMContentLoaded', (event) => {
  inputTextListener("<?php echo $id; ?>");
});
</script>
