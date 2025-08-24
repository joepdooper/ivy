<?php

use Ivy\Manager\RouterManager;

// -- HOME
RouterManager::instance()->get('/', '\Ivy\Controller\TemplateController@root');
// -- PROFILE
RouterManager::instance()->get('/profile/(\d+)', '\Ivy\Controller\ProfileController@public');