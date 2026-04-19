<?php

namespace Moment\Collection\MomentPeople;

use Contacts\Contact;
use Ivy\Abstract\Model;
use Ivy\Trait\Factory;
use Moment\Moment;


/**
 * @property ?array $contacts
 * @property ?array $moments
 */
class MomentPeople extends Model
{
    use Factory;

    protected string $table = 'moments_people';

    protected array $columns = [
        'moment_id',
        'contact_id',
    ];

    protected int $moment_id;

    protected int $contact_id;

    public function contacts(): ?array
    {
        return $this->hasMany(Contact::class, 'id', 'contact_id');
    }

    public function moments(): array
    {
        return $this->hasMany(Moment::class, 'id', 'moment_id');
    }
}
