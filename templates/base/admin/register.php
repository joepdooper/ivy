<?php
defined('_BASE_PATH') ?: header('location: ../../../index.php');
?>

<div class="admin-container">

  <div class="outer">
    <div class="inner">
      <h1>Register</h1>
    </div>
  </div>

  <div class="outer">
    <div class="inner">
      <div class="form-group">
        <!-- <label for="name">Name</label> -->
        <input type="text" name="username" placeholder="name" class="form-control form-control-lg">
      </div>
      <div class="form-group">
        <!-- <label for="email">Email Address</label> -->
        <input type="email" name="email" placeholder="email" class="form-control form-control-lg">
      </div>
      <div class="form-group">
        <!-- <label for="password">Password</label> -->
        <input type="password" name="password" placeholder="password" class="form-control form-control-lg">
      </div>
    </div>
  </div>

  <div class="outer">
    <div class="inner text-align-center">
      <?php $button->submit('register'); ?>
    </div>
    <div class="inner text-align-center">
      <a href="login" class="btn btn-light btn-block">Have an account? Login</a>
    </div>
  </div>

</div>
