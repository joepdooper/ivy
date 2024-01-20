<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
$settings = (new Ivy\Setting)->get()->data();
?>

<form action="<?php print _BASE_PATH . 'admin/setting/post'; ?>" method="POST" enctype="multipart/form-data">

  <div class="outer">
    <div class="inner">
      <h1>Settings</h1>
    </div>
  </div>

  <div class="outer">
    <div class="inner">
      <table>
        <thead>
          <tr>
            <th></th>
            <th>name</th>
            <th>code</th>
            <th>value</th>
            <th>info</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($settings as $setting): ?>
            <?php if(isset($setting->name)): ?>
              <tr>
                <td>
                  <?php
                  $button->switch(
                    'setting[' . $setting->id . '][bool]',
                    $setting->bool
                  );
                  ?>
                </td>
                <?php if(empty($setting->name)): ?>
                  <td><strong><input type="text" name="setting[<?php echo $setting->id; ?>][name]" value="<?php echo $setting->name; ?>"></strong></td>
                <?php else: ?>
                  <td><?php echo $setting->name; ?></td>
                <?php endif; ?>
                <td><pre><code><?php echo '$setting' . "['" . strtolower(str_replace(' ', '_', $setting->name)) . "']"; ?></code></pre></td>
                <td><input type="text" name="setting[<?php echo $setting->id; ?>][value]" value="<?php echo $setting->value; ?>"></td>
                <?php if(empty($setting->info) && !empty($setting->name)): ?>
                  <td><strong><input type="text" name="setting[<?php echo $setting->id; ?>][info]" value="<?php echo $setting->info; ?>"></strong></td>
                <?php else: ?>
                  <td><?php echo $setting->info; ?></td>
                <?php endif; ?>
                <td>
                  <input type="hidden" name="setting[<?php echo $setting->id; ?>][id]" value="<?php echo $setting->id; ?>">
                  <?php $button->delete("setting[" . $setting->id . "][delete]","setting_" . $setting->id); ?>
                </td>
              </tr>
            <?php endif; ?>
          <?php endforeach;?>
          <tr>
            <td colspan="5">
              <input type="text" name="setting[][name]" placeholder="Add setting name">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="outer">
    <div class="inner text-align-center">
      <?php $button->submit('update'); ?>
    </div>
  </div>

</form>
