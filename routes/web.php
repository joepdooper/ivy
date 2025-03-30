<?php

use Ivy\Manager\RouterManager;

// -- PROFILE
RouterManager::instance()->get('/profile/(\d+)', '\Ivy\Controller\ProfileController@public');