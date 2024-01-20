<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<form action="<?php print _BASE_PATH . 'admin/user/login/'; ?>" method="POST" enctype="multipart/form-data">
  <div class="admin-container">

    <div class="outer">
      <div class="inner">
        <h1>Login</h1>
      </div>
    </div>

    <div class="outer">
      <div class="inner">
        <div class="form-group">
          <!-- <label for="email">Email Address</label> -->
          <input type="email" name="email" placeholder="email">
        </div>
        <div class="form-group">
          <!-- <label for="password">Password</label> -->
          <input type="password" name="password" placeholder="password">
        </div>
      </div>
    </div>

    <div class="outer">
      <div class="inner text-align-center">
        <?php $button->submit('login'); ?>
      </div>
      <div class="inner text-align-center">
        <a href="register">No account? Register!</a>
        <br><br>
        <a href="reset">Forgot password? Reset!</a>
      </div>
    </div>

  </div>
</form>
