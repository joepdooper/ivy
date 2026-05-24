<?php

namespace NextcloudApi;

use Illuminate\Database\Eloquent\Model;
use Ivy\Shared\Traits\HasPolicies;

/**
 * @method static static where(string $column, mixed $value = null)
 * @method static static select(string ...$columns)
 * @method static static find(int $id)
 * @method static static first()
 *
 * @property int $id
 * @property string $url
 * @property string $username
 * @property string $password
 */
class NextcloudApi extends Model
{
    use HasPolicies;

    protected $fillable = [
        'url',
        'user',
        'password'
    ];
}
