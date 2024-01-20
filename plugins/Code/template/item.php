<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
$code = (new \Code\Item)->where('id', $item->table_id)->getRow()->data();
$languages = ['css','php','javascript','shell','sql']
?>

<div class="item item-code col-12 <?php if(!$item->parent): ?>col-md-6 col-lg-4<?php endif; ?>" id="item-<?php print $item->id; ?>">
  <div class="inner">

    <?php if($auth->isLoggedIn() && $item->author): ?>
      <form action="<?php print _BASE_PATH . 'code/update/' . $item->id . $template->url; ?>" method="POST" enctype="multipart/form-data">
        <select name="language">
          <?php foreach ($languages as $language): ?>
            <option <?php if($code->language == $language):?>selected<?php endif; ?> value="<?php print $language; ?>"><?php print $language; ?></option>
          <?php endforeach; ?>
        </select>
        <textarea class="bg-secondary" name="code"><?php print $code->code; ?></textarea>
        <?php include $template->setTemplateFile('include/item_admin_buttons.php'); ?>
      </form>
    <?php else: ?>
      <pre><code data-language="<?php print $code->language; ?>"><?php print $code->code; ?></code></pre>
    <?php endif; ?>

  </div>
</div>
