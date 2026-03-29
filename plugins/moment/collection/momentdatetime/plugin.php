<?php

use Ivy\Manager\AssetManager;
use Ivy\Model\User;

if (User::canEditAsEditor()) {
    AssetManager::addJS('plugins/moment/collection/momentdatetime/js/calendar_admin.js');
}
