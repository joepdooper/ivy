<?php
// -- START
$router->get('/', function() use($db, $auth, $page, $button){
  $page->content = $page->setTemplateFile('include/start.php');
  include $page->setTemplateFile('main.php');
});

// -- PLUGIN
$router->get('/plugin/(\w+)', function($id) use($db, $auth, $page, $button) {
  if(canEditAsSuperAdmin($auth)):
    $page->content = $page->setTemplateFile(_PLUGIN_PATH . $id . '/template/' . 'settings.php');
    include $page->setTemplateFile('main.php');
  endif;
});

// -- PROFILE
$router->get('/profile/(\d+)', function($id) use($db, $auth, $page, $button) {
  $page->content = $page->setTemplateFile('include/profile.php');
  include $page->setTemplateFile('main.php');
});

// -- ADMIN
$router->get('/admin/(\w+)(/[^/]+)?(/[^/]+)?', function($id, $selector = null, $token = null) use($db, $auth, $page, $button) {
  if(canEditAsAdmin($auth) || (!canEditAsAdmin($auth) && in_array($id,['register','login','logout','reset','profile']))):
    $form = new \stdClass;
    $form->action = _BASE_PATH . 'post/' . $id;
    $form->content = $page->setTemplateFile('admin/' . $id . '.php');
    $page->content = _PUBLIC_PATH . '/core/include/form.php';
    include $page->setTemplateFile('main.php');
  endif;
});
?>
