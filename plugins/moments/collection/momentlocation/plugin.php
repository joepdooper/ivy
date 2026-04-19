<?php

use Ivy\Manager\AssetManager;
use Ivy\Model\User;

if (User::canEditAsEditor()) {
    AssetManager::addJS('plugins/moment/collection/momentlocation/js/location_admin.js');
}
