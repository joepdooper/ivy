<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
$installed = array();
$plugins = new Ivy\Plugin();
?>

<div class="outer">
  <div class="inner">
    <h1>Plugins</h1>
  </div>
</div>

<div class="outer">
  <div class="inner">
    <table>
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Description</th>
          <th>Version</th>
          <th>Type</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($plugins->get()->data() as $row):?>
          <tr>
            <td>
              <?php
              $button->switch(
                'plugin[' . $row->id . ']',
                $row->active
              );
              ?>
            </td>
            <td><strong><?php echo $row->name; ?></strong></td>
            <td><?php echo $row->desc; ?></td>
            <td><?php echo $row->version; ?></td>
            <td><?php echo $row->type; ?></td>
            <td>
              <div class="editButton clearfix">
                <?php $button->delete('delete[' . $row->id . ']',$row->id); ?>
                <?php if (!empty($row->settings)):?>
                  <a class="button" href="<?php echo _BASE_PATH; ?>plugin/<?php echo $row->url; ?>">
                    <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/settings.svg"); ?>
                  </a>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php array_push($installed,$row->url); ?>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<div class="outer">
  <div class="inner">
    <?php $plugouts = scandir(_PUBLIC_PATH . _PLUGIN_PATH); ?>
    <div class="select-container">
      <span class="select-arrow">
        <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/chevron-down.svg"); ?>
      </span>
      <select name="plugout">
        <option disabled selected value>Install plugin</option>
        <?php foreach ($plugouts as $val): ?>
          <?php if(($val[0] != ".") && !in_array($val,$installed)): ?>
            <?php $plugout = simplexml_load_file(_PUBLIC_PATH . _PLUGIN_PATH . $val . '/info.xml'); ?>
            <option value="<?php echo $plugout->url; ?>"><?php echo $plugout->name . ' (' . $plugout->description . ')'; ?></option>
          <?php endif;?>
        <?php endforeach;?>
      </select>
    </div>
  </div>
</div>

<div class="outer">
  <div class="inner text-align-center">
    <?php $button->submit('update'); ?>
  </div>
</div>
