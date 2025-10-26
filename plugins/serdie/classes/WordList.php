<?php

namespace Serdie;

use Ivy\Model;

class WordList extends Model
{

    protected string $table = 'serdie_wordlist';
    protected string $path = Path::get('BASE_PATH') . 'plugin/Serdie';

}
