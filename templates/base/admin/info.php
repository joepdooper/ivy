<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
$infos = (new Ivy\Info)->get()->data();
?>

<div class="outer">
  <div class="inner">
    <h1>Infos</h1>
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
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($infos as $info): ?>
          <?php if(isset($info->name)): ?>
            <tr>
              <td>
                <?php
                $button->switch(
                  'info[' . $info->id . '][bool]',
                  $info->bool
                );
                ?>
              </td>
              <?php if(empty($info->name)): ?>
                <td><strong><input type="text" name="info[<?php echo $info->id; ?>][name]" value="<?php echo $info->name; ?>"></strong></td>
              <?php else: ?>
                <td><?php echo $info->name; ?></td>
              <?php endif; ?>
              <td><pre><code><?php echo '$info' . '->' . strtolower(str_replace(' ', '_', $info->name)); ?></code></pre></td>
              <td><input type="text" name="info[<?php echo $info->id; ?>][value]" value="<?php echo $info->value; ?>"></td>
              <td>
                <input type="hidden" name="info[<?php echo $info->id; ?>][id]" value="<?php echo $info->id; ?>">
                <?php $button->delete("info[" . $info->id . "][delete]","info_" . $info->id); ?>
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach;?>
        <tr>
          <td colspan="5">
            <input type="text" name="info[][name]" placeholder="Add info name">
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
