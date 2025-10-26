<?php

namespace Serdie;

use Ivy\Model;

class Player extends Model
{

    protected string $table = 'serdie_player';
    protected string $path = Path::get('BASE_PATH') . 'serdie/player';

}
