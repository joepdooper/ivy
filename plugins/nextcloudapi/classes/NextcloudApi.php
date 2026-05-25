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
 * @property string $protocol
 * @property string $url
 * @property int $port
 * @property string $username
 * @property string $password
 */
class NextcloudApi extends Model
{
    use HasPolicies;

    protected $fillable = [
        'protocol',
        'url',
        'port',
        'username',
        'password'
    ];

    public function href(): string
    {
        $url = $this->protocol . '://' . $this->url;
        if($this->port) {
            $url .= ':' . $this->port;
        }

        return $url;
    }
}
