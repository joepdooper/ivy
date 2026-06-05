<?php

namespace Contacts;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Ivy\Shared\Base\Entity;
use Ivy\Shared\Traits\HasPolicies;
use Ivy\User\Domain\Entity\Profile;

class Contact extends Entity
{
    use HasPolicies;

    protected $fillable = [
        'name',
        'email',
        'birthday',
        'profile_id',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'id','profile_id');
    }
}
