<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
$users = (new Ivy\User)->get()->data();
?>

<div class="outer">
  <div class="inner">
    <h1>Users</h1>
  </div>
</div>

<div class="outer">
  <div class="inner">
    <table>
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th>super_admin</th>
          <th>admin</th>
          <th>editor</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($users as $user):?>
          <tr>
            <td><strong><?php echo $user->username; ?></strong></td>
            <td><?php echo $user->email; ?></td>
            <td>
              <?php
              $button->switch(
                'users[' . $user->id . '][super_admin]',
                $auth->admin()->doesUserHaveRole($user->id, \Delight\Auth\Role::SUPER_ADMIN)
              );
              ?>
            </td>
            <td>
              <?php
              $button->switch(
                'users[' . $user->id . '][admin]',
                $auth->admin()->doesUserHaveRole($user->id, \Delight\Auth\Role::ADMIN),
              );
              ?>
            </td>
            <td>
              <?php $button->switch(
                'users[' . $user->id . '][editor]',
                $auth->admin()->doesUserHaveRole($user->id, \Delight\Auth\Role::EDITOR)
              );
              ?>
            </td>
            <td><?php $button->delete("users[" . $user->id . "][delete]","users_" . $user->id); ?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<div class="outer">
  <div class="inner text-align-center">
    <?php $button->submit('update'); ?>
  </div>
</div>
