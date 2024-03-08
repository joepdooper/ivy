<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
$installed = array();
$plugins = (new Ivy\Plugin)->get()->data();
?>

<form action="<?php print _BASE_PATH . 'admin/plugin/post'; ?>" method="POST" enctype="multipart/form-data">

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
          <?php foreach($plugins as $plugin):?>
            <tr>
              <td>
                <?php
                \Ivy\Button::switch(
                  'plugin[' . $plugin->id . '][active]',
                  $plugin->active
                );
                ?>
              </td>
              <td><strong><?php echo $plugin->name; ?></strong></td>
              <td><?php echo $plugin->desc; ?></td>
              <td><?php echo $plugin->version; ?></td>
              <td><?php echo $plugin->type; ?></td>
              <td>
                <input type="hidden" name="plugin[<?php echo $plugin->id; ?>][id]" value="<?php echo $plugin->id; ?>">
                <?php \Ivy\Button::delete('plugin[' . $plugin->id . '][delete]',"plugin_".$plugin->id); ?>
                <?php if (!empty($plugin->settings)):?>
                  <a class="button" href="<?php echo _BASE_PATH; ?>plugin/<?php echo $plugin->url; ?>">
                    <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/settings.svg"); ?>
                  </a>
                <?php endif; ?>
              </td>
            </tr>
            <?php array_push($installed,$plugin->url); ?>
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
        <select name="plugin[][url]">
          <option disabled selected value>Install plugin</option>
          <?php foreach ($plugouts as $val): ?>
            <?php if(($val[0] != ".") && !in_array($val,$installed)): ?>
              <?php $plugout = json_decode(file_get_contents(_PUBLIC_PATH . _PLUGIN_PATH . $val . '/info.json')); ?>
                  <option value="<?php echo $plugout->url; ?>"><?php echo $plugout->name . ' (' . $plugout->description . ')'; ?></option>
            <?php endif;?>
          <?php endforeach;?>
        </select>
      </div>
    </div>
  </div>

  <div class="outer">
    <div class="inner text-align-center">
      <?php \Ivy\Button::submit('update'); ?>
    </div>
  </div>

</form>
