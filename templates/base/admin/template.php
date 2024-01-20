<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<form action="<?php print _BASE_PATH . 'admin/template/post'; ?>" method="POST" enctype="multipart/form-data">

  <div class="outer">
    <div class="inner">
      <h1>Templates</h1>
    </div>
  </div>

  <div class="outer">
    <div class="inner">

      <table>
        <thead>
          <tr>
            <th>name</th>
            <th>code</th>
            <th>select</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <input type="hidden" name="template[1][id]" value="1">
              Base
            </td>
            <td><pre><code>_TEMPLATE_BASE</code></pre></td>
            <td>
              <div class="select-container">
                <span class="select-arrow">
                  <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/chevron-down.svg"); ?>
                </span>
                <select name="template[1][value]">
                  <?php foreach (array_diff(scandir(_PUBLIC_PATH . _TEMPLATES_PATH), array('.', '..', '.DS_Store')) as $val): ?>
                    <?php $theme = simplexml_load_file(_PUBLIC_PATH . _TEMPLATES_PATH . $val . '/info.xml'); ?>
                    <option value="<?php echo $theme->url ?>" <?php (basename(_TEMPLATE_BASE) != $theme->url) ?: print 'selected';?>><?php echo $theme->name . ' (' . $theme->description . ')'; ?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="template[2][id]" value="2">
              Sub
            </td>
            <td><pre><code>_TEMPLATE_SUB</code></pre></td>
            <td>
              <div class="select-container">
                <span class="select-arrow">
                  <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/chevron-down.svg"); ?>
                </span>
                <select name="template[2][value]">
                  <?php foreach (array_diff(scandir(_PUBLIC_PATH . _TEMPLATES_PATH), array('.', '..', '.DS_Store')) as $val): ?>
                    <?php $theme = simplexml_load_file(_PUBLIC_PATH . _TEMPLATES_PATH . $val . '/info.xml'); ?>
                    <option value="<?php echo $theme->url ?>" <?php (basename(_TEMPLATE_SUB) != $theme->url) ?: print 'selected';?>><?php echo $theme->name . ' (' . $theme->description . ')'; ?></option>
                  <?php endforeach;?>
                </select>
              </div>
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
