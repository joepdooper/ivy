<div class="select-container">
  <span class="select-arrow"></span>
  <select name="<?php echo $name; ?>">
    <?php foreach($list as $key => $value):?>
      <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $selected) ? 'selected="selected"' : ''; ?>><?php echo $value['subject']; ?></option>
    <?php endforeach;?>
  </select>
</div>
