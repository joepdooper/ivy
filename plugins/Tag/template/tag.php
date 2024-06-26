<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Template;
use Ivy\User;
global $auth, $tag;
?>

<?php if (User::canEditAsEditor($auth) && Template::$content->author): ?>
  <div class="select-container">
    <span class="select-arrow">
      <?php print file_get_contents(_BASE_PATH . "media/icon/" . "feather/chevron-down.svg"); ?>
    </span>
    <select name="tag">
      <?php foreach(((new \Tag\Item)->get()->data()) as $option):?>
        <option value="<?php echo $option->id; ?>" <?php echo (isset($tag->id) && ($tag->id == $option->id)) ? 'selected="selected"' : ''; ?>><?php echo $option->value; ?></option>
      <?php endforeach;?>
    </select>
  </div>
<?php else: ?>
  <div class="tag"><?php print $tag->value; ?></div>
<?php endif; ?>
