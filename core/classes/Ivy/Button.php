<?php
namespace Ivy;

class Button extends Page {

  public function delete($name = null, $value = null, $id = null, $formaction = null) {
    include(_PUBLIC_PATH . 'core/inputs/input.delete.php');
    include $this->setTemplateFile('buttons/button.delete.php');
    include $this->setTemplateFile('buttons/button.confirm.php');
  }

  public function remove($name = null, $value = null) {
    include $this->setTemplateFile('buttons/button.remove.php');
  }

  public function close($name = null, $value = null) {
    include $this->setTemplateFile('buttons/button.close.php');
  }

  public function save($text = null, $value = null) {
    include $this->setTemplateFile('buttons/button.save.php');
  }

  public function confirm($text = null, $value = null) {
    include $this->setTemplateFile('buttons/button.confirm.php');
  }

  public function submit($text = null) {
    include $this->setTemplateFile('buttons/button.submit.php');
  }

  public function link($url = null, $text = null, $icon = null, $label = null) {
    include $this->setTemplateFile('buttons/button.link.php');
  }

  public function upload($name = null, $value = null, $id = null) {
    include(_PUBLIC_PATH . 'core/inputs/input.upload.php');
    include $this->setTemplateFile('buttons/button.upload.php');
  }

  public function switch($name = null, $value = null, $id = null) {
    include _PUBLIC_PATH . 'core/inputs/input.checkbox.php';
    include $this->setTemplateFile('buttons/button.switch.php');
  }

  public function visible($name = null, $value = null, $id = null) {
    include(_PUBLIC_PATH . 'core/inputs/input.checkbox.php');
    include $this->setTemplateFile('buttons/button.visible.php');
  }

  public function select($name = null, $options = null) {
    include $this->setTemplateFile('buttons/select.php');
  }

  public function toolbar() {
    include $this->setTemplateFile('buttons/toolbar.php');
  }

}
?>
