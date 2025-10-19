<?php

namespace Moment;

use Items\ItemTrait;
use Ivy\Abstract\Model;
use Ivy\Model\Profile;
use Ivy\Trait\Factory;
use Moment\Collection\MomentDateTime\MomentDateTime;
use Moment\Collection\MomentLocation\MomentLocation;
use Moment\Collection\MomentPeople\MomentPeople;
use Tags\TagTrait;

class Moment extends Model
{
    use ItemTrait, TagTrait, Factory;

    protected string $table = "moments";
    protected string $slug = "title";

    protected array $columns = [
        'title',
        'token'
    ];

    protected string $title;
    protected ?string $token;

    protected ?MomentDateTime $momentDateTime;
    protected ?MomentLocation $momentLocation;

    public function getDateTime(): ?MomentDateTime
    {
        $this->momentDateTime = $this->hasOne(MomentDateTime::class, 'moment_id');

        return $this->momentDateTime;
    }

    public function getLocation(): ?MomentLocation
    {
        $this->momentLocation = $this->hasOne(MomentLocation::class, 'moment_id');

        return $this->momentLocation;
    }

    public function getPeople(): array
    {
        $momentPeople = $this->hasMany(MomentPeople::class, 'moment_id');
        $userIds = array_map(fn($mp) => $mp->user_id, $momentPeople);

        return (new Profile)->whereIn('user_id', $userIds)->fetchAll();
    }
}
