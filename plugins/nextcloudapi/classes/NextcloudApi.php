<?php

namespace NextcloudApi;

use Ivy\Shared\Base\Entity;
use Ivy\Shared\Infrastructure\Cast\CryptedCast;
use Ivy\Shared\Traits\HasPolicies;

/**
 * @property int $id
 * @property string $protocol
 * @property string $url
 * @property int $port
 * @property string $username
 * @property string $password
 */
class NextcloudApi extends Entity
{
    use HasPolicies;

    protected NextcloudApiResponse $response;

    protected $fillable = [
        'protocol',
        'url',
        'port',
        'username',
        'password',
    ];

    protected $casts = [
        'password' => CryptedCast::class,
    ];

    public function href(): string
    {
        $url = $this->protocol.'://'.$this->url;
        if ($this->port) {
            $url .= ':'.$this->port;
        }

        return $url;
    }
}
