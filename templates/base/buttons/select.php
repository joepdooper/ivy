<select name="<?php echo $name;?>">
  <option disabled value>Select <?php echo $name;?></option>
  <?php foreach($option as $key => $val):?>
    <option value="<?php echo $key;?>" <?php if($key==$selected){ print 'selected="selected"' }?>><?php echo $val;?></option>
  <?php endforeach;?>
</select>
<!-- ?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/chevron-down.svg"); ? -->
