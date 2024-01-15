<?php
// -- START
$router->get('/', function() use($db, $auth, $template, $button){
  $template->content = $template->setTemplateFile('include/start.php');
  include $template->setTemplateFile('main.php');
});

// -- PLUGIN
$router->get('/plugin/(\w+)', function($id) use($db, $auth, $template, $button) {
  if(canEditAsSuperAdmin($auth)):
    $template->content = $template->setTemplateFile(_PLUGIN_PATH . $id . '/template/' . 'settings.php');
    include $template->setTemplateFile('main.php');
  endif;
});

// -- PROFILE
$router->get('/profile/(\d+)', function($id) use($db, $auth, $template, $button) {
  $template->content = $template->setTemplateFile('include/profile.php');
  include $template->setTemplateFile('main.php');
});

// -- ADMIN
$router->get('/admin/(\w+)(/[^/]+)?(/[^/]+)?', function($id, $selector = null, $token = null) use($db, $auth, $template, $button) {
  if(canEditAsAdmin($auth) || (!canEditAsAdmin($auth) && in_array($id,['register','login','logout','reset','profile']))):
    $template->content = $template->setTemplateFile('admin/' . $id . '.php');
    include $template->setTemplateFile('main.php');
  endif;
});
?>
