<?php
namespace Ivy;

#[\AllowDynamicProperties]

class Setting extends Model {
    use Cache;

    protected $table = 'setting';
    protected $path = _BASE_PATH . 'admin/setting';

}
