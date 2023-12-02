<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<div class="outer">
  <div class="inner">
    <h1>Media</h1>
  </div>
</div>
<div class="outer">

  <div class="inner">

    <?php if(isset($javascripts->vue->bool)): ?>
      <div id="vuemedialist" v-cloak>
        <!-- <h2>{{ message }}</h2> -->
        <?php include _PUBLIC_PATH . $page->setTemplateFile('content/media/media_list_vue.php'); ?>
      </div>
    <?php else: ?>
      <div id="medialist">
        <input type="radio" class="medialistcheckbox visually-hidden" id="media/upload_SUFFIX" value="media/upload" name="select" checked>
        <?php
        $media = new \Ivy\Media();
        $media->tpl = _PUBLIC_PATH . $page->setTemplateFile('content/media/media_list.php');
        $media->getFileStructure(_PUBLIC_PATH . 'media/upload');
        ?>
      </div>
    <?php endif; ?>

  </div>

  <div class="inner text-align-center">
    <label for="upload-mode" class="button">
      <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/upload.svg"); ?>
    </label>
    <label for="add-folder-mode" class="button">
      <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/folder-plus.svg"); ?>
    </label>
    <label for="rename-mode" class="button">
      <?php print file_get_contents(_PUBLIC_PATH . "media/icon/" . "feather/edit-3.svg"); ?>
    </label>
    <label for="delete-mode" class="button">
      <?php print file_get_contents(_PUBLIC_PATH . "media/icon/" . "feather/trash-2.svg"); ?>
    </label>
    <label for="show-file" class="button">
      <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/eye.svg"); ?>
    </label>
  </div>

</div>

<?php
if(canEditArticle($auth)):
  $overlay = new Overlay();
  $overlay->popup('upload-mode', _PUBLIC_PATH . $page->setTemplateFile('content/media/popup_upload.php'));
  $overlay->popup('add-folder-mode', _PUBLIC_PATH . $page->setTemplateFile('content/media/popup_add_folder.php'));
  $overlay->popup('rename-mode', _PUBLIC_PATH . $page->setTemplateFile('content/media/popup_rename.php'));
  $overlay->popup('delete-mode', _PUBLIC_PATH . $page->setTemplateFile('content/media/popup_delete.php'));
  $overlay->popup('show-file', _PUBLIC_PATH . $page->setTemplateFile('content/media/popup_show_file.php'));
endif;
?>

<?php if(isset($javascripts->vue->bool)): ?>
  <script src="<?php print _BASE_PATH . $page->setTemplateFile('js/media_vue.js'); ?>"></script>
<?php else: ?>
  <script src="<?php print _BASE_PATH . $page->setTemplateFile('js/media.js'); ?>"></script>
<?php endif; ?>
