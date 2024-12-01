<?php

namespace Ivy;

class Setting extends Model
{

    use Stash;

    protected string $table = 'setting';
    protected string $path = _BASE_PATH . 'admin/setting';

    public int $id;
    public string $name;
    public bool $bool;
    public string $value;
    public string $info;

}
