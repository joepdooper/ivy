<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$tags = (new \Tag\Item)->get()->data();
?>

<form action="<?php print _BASE_PATH . 'tag/post'; ?>" method="POST" enctype="multipart/form-data">

  <div class="outer">
    <div class="inner">
      <h1>Tags</h1>
    </div>
  </div>

  <div class="outer">
    <div class="inner">

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tags as $row): ?>
            <tr>
              <td><input type="text" name="tag[<?php echo $row->id; ?>][value]" value="<?php echo $row->value; ?>"></td>
              <td>
                <input type="hidden" name="tag[<?php echo $row->id; ?>][id]" value="<?php echo $row->id; ?>">
                <?php \Ivy\Button::delete("tag[" . $row->id . "][delete]","tag_" . $row->id); ?>
              </td>
            </tr>
          <?php endforeach;?>
          <tr>
            <td colspan="2">
              <input type="text" name="tag[][value]" placeholder="Add tag">
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
