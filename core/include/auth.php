<?php

function canEditArticle(\Delight\Auth\Auth $auth) {
    return $auth->hasAnyRole(
      \Delight\Auth\Role::EDITOR,
      \Delight\Auth\Role::ADMIN,
      \Delight\Auth\Role::SUPER_ADMIN
    );
}
function canEditAsAdmin(\Delight\Auth\Auth $auth) {
    return $auth->hasAnyRole(
      \Delight\Auth\Role::ADMIN,
      \Delight\Auth\Role::SUPER_ADMIN
    );
}
function canEditAsSuperAdmin(\Delight\Auth\Auth $auth) {
    return $auth->hasAnyRole(
      \Delight\Auth\Role::SUPER_ADMIN
    );
}

function userIsSuperAdmin(\Delight\Auth\Auth $auth, $id) {
    return $auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::SUPER_ADMIN);
}
function userIsAdmin(\Delight\Auth\Auth $auth, $id) {
    return $auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN);
}
function userIsEditor(\Delight\Auth\Auth $auth, $id) {
    return $auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::EDITOR);
}

?>
