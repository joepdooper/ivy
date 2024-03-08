<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
global $auth;
$image_sizes = (new \Image\Settings)->get()->data();
?>

<form action="<?php print _BASE_PATH . 'image_sizes/post'; ?>" method="POST" enctype="multipart/form-data">

  <div class="outer">
    <div class="inner">
      <h1>Image sizes</h1>
    </div>
  </div>

  <div class="outer">
    <div class="inner">

      <table>
        <thead>
          <tr>
            <th></th>
            <th>Folder</th>
            <th>Width</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
              <?php foreach($image_sizes as $row):?>
                <tr>
                  <td>
                    <?php
                    \Ivy\Button::switch(
                      'image_sizes[' . $row->id . '][bool]',
                      $row->bool
                    );
                    ?>
                  </td>
                  <?php if(empty($row->name)): ?>
                    <td><strong><input type="text" name="image_sizes[<?php echo $row->id; ?>][name]" value="<?php echo $row->name; ?>"></strong></td>
                  <?php else: ?>
                    <td><?php echo $row->name; ?></td>
                  <?php endif; ?>
                  <td>
                    <strong>
                      <input type="text" name="image_sizes[<?php echo $row->id; ?>][value]" value="<?php echo $row->value; ?>">
                    </strong>
                  </td>
                  <td>
                    <input type="hidden" name="image_sizes[<?php echo $row->id; ?>][id]" value="<?php echo $row->id; ?>">
                    <?php \Ivy\Button::delete("image_sizes[" . $row->id . "][delete]","size_" . $row->id); ?>
                  </td>
                </tr>
              <?php endforeach;?>
          <tr>
            <td colspan="4">
              <input type="text" name="image_sizes[][name]" placeholder="New size folder">
            </td>
            <td>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <div class="outer">
    <div class="inner text-align-center">
      <?php \Ivy\Button::submit('Save'); ?>
    </div>
  </div>

</form>
