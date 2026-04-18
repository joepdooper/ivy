<?php

namespace Contacts;

use Ivy\Abstract\Model;
use Ivy\Model\Profile;
use Ivy\Trait\HasDirtyChecking;

/**
 * @property ?Profile $profile
 */
class Contact extends Model
{
    use HasDirtyChecking;

    protected string $table = 'contacts';

    protected string $path = 'admin/plugin/contacts';

    /** @var string[] */
    protected array $columns = [
        'name',
        'email',
        'birthday',
        'profile_id',
    ];

    protected string $name;
    protected ?string $email;
    protected ?string $birthday = null;

    protected ?int $profile_id = null;

    public function profile(): ?Profile
    {
        return $this->hasOne(Profile::class, 'id','profile_id');
    }
}
