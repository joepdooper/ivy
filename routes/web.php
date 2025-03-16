<?php

use Ivy\App;

// -- PROFILE
App::router()->get('/profile/(\d+)', '\Ivy\ProfileController@public');