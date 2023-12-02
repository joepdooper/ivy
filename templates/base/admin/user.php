<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
$allUsers = $db->select('SELECT `id`, `email`, `username`, `status`, `verified`, `roles_mask`, `registered`, `last_login` FROM `users`');
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
        <?php foreach($allUsers as $row):?>
          <tr>
            <td><strong><?php echo $row['username']; ?></strong></td>
            <td><?php echo $row['email']; ?></td>
            <td>
              <?php
              $button->switch(
                'users[' . $row['id'] . '][super_admin]',
                $auth->admin()->doesUserHaveRole($row['id'], \Delight\Auth\Role::SUPER_ADMIN)
              );
              ?>
            </td>
            <td>
              <?php
              $button->switch(
                'users[' . $row['id'] . '][admin]',
                $auth->admin()->doesUserHaveRole($row['id'], \Delight\Auth\Role::ADMIN),
              );
              ?>
            </td>
            <td>
              <?php $button->switch(
                'users[' . $row['id'] . '][editor]',
                $auth->admin()->doesUserHaveRole($row['id'], \Delight\Auth\Role::EDITOR)
              );
              ?>
            </td>
            <td><?php $button->delete('delete',$row['id']); ?></td>
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
