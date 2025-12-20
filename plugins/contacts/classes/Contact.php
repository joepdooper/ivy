<?php

namespace Contacts;

use Ivy\Abstract\Model;
use Ivy\Model\User;

class Contact extends Model
{
    protected string $table = 'contacts';
    protected string $path = 'admin/plugin/contacts';
    protected array $columns = [
        'name',
        'image',
        'birthday',
        'user_id'
    ];

    protected string $name;
    protected ?string $image = null;
    protected ?int $user_id = null;
    protected ?string $birthday;

    public function getUser(): User
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
