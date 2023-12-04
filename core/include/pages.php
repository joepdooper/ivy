<!-- START -->
<?php
$router->get('/', function() use($db, $auth, $page, $button){
  $page->content = $page->setTemplateFile('content/home.php');
  include $page->setTemplateFile('main.php');
});
?>

<!-- ITEM -->
<?php
$router->get('/item/(\d+)', function($id) use($db, $auth, $page, $button) {
  $item = (new \Ivy\Item)->where('id',$id)->getRow()->data();
  $page->content = $page->setTemplateFile(_PLUGIN_PATH . $item->plugin . '/template/' . $item->page_template_file);
  include $page->setTemplateFile('main.php');
});
?>

<!-- PLUGIN -->
<?php
$router->get('/plugin/(\w+)', function($id) use($db, $auth, $page, $button, $msg) {
  if(canEditAsSuperAdmin($auth)):
    $page->content = $page->setTemplateFile(_PLUGIN_PATH . $id . '/template/' . 'settings.php');
    include $page->setTemplateFile('main.php');
  endif;
});
?>

<!-- PROFILE -->
<?php
$router->get('/profile/(\d+)', function($id) use($db, $auth, $page, $button) {
  $page->content = $page->setTemplateFile('content/profile.php');
  include $page->setTemplateFile('main.php');
});
?>

<!-- ADMIN -->
<?php
$router->get('/admin/(\w+)(/[^/]+)?(/[^/]+)?', function($id, $selector = null, $token = null) use($db, $auth, $page, $button) {
  if(canEditAsAdmin($auth) || (!canEditAsAdmin($auth) && in_array($id,['register','login','logout','reset','profile']))):
    print $selector;
    $form = new \stdClass;
    $form->action = _BASE_PATH . 'post/' . $id;
    $form->content = $page->setTemplateFile('admin/' . $id . '.php');
    $page->content = _PUBLIC_PATH . '/core/include/form.php';
    include $page->setTemplateFile('main.php');
  endif;
});
?>
