<?php

namespace Contacts;

use Illuminate\Database\Eloquent\Model;
use Ivy\Shared\Traits\HasPolicies;
use Ivy\User\Domain\Entity\Profile;

class Contact extends Model
{
    use HasPolicies;

    protected $fillable = [
        'name',
        'email',
        'birthday',
        'profile_id',
    ];

    public function profile(): ?Profile
    {
        return $this->hasOne(Profile::class, 'id','profile_id');
    }
}
