<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
$options = new Ivy\Option();
?>

<div class="outer">
  <div class="inner">
    <h1>Options</h1>
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
          <th>info</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($options->get()->data() as $row):?>
          <tr>
            <td>
              <?php
              $button->switch(
                'option[' . $row->id . '][bool]',
                $row->bool
              );
              ?>
            </td>
            <?php if(empty($row->name)): ?>
              <td><strong><input type="text" name="option[<?php echo $row->id; ?>][name]" value="<?php echo $row->name; ?>"></strong></td>
            <?php else: ?>
              <td><?php echo $row->name; ?></td>
            <?php endif; ?>
            <td><pre><code><?php echo '$option' . '->' . strtolower(str_replace(' ', '_', $row->name)); ?></code></pre></td>
            <?php if(empty($row->info) && !empty($row->name)): ?>
              <td><strong><input type="text" name="option[<?php echo $row->id; ?>][info]" value="<?php echo $row->info; ?>"></strong></td>
            <?php else: ?>
              <td><?php echo $row->info; ?></td>
            <?php endif; ?>
            <td>
              <input type="hidden" name="option[<?php echo $row->id; ?>][id]" value="<?php echo $row->id; ?>">
              <?php $button->delete("option[" . $row->id . "][delete]","option_" . $row->id); ?>
            </td>
          </tr>
        <?php endforeach;?>
        <tr>
          <td colspan="5">
            <input type="text" name="option[][name]" placeholder="Add option name">
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
