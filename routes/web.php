<?php

use Ivy\App;

// -- PROFILE
App::router()->get('/profile/(\d+)', '\Ivy\Controller\ProfileController@public');