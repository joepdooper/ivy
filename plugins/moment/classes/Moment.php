<?php

namespace Moment;

use Items\ItemTrait;
use Ivy\Abstract\Model;
use Ivy\Model\Profile;
use Ivy\Trait\Factory;
use Ivy\Trait\HasFilters;
use Moment\Collection\MomentDateTime\MomentDateTime;
use Moment\Collection\MomentLocation\MomentLocation;
use Moment\Collection\MomentPeople\MomentPeople;
use Tags\TagTrait;

class Moment extends Model
{
    use ItemTrait, TagTrait, Factory, HasFilters;

    protected string $table = "moments";
    protected string|array $slug = "title";

    protected array $columns = [
        'title',
        'item_id',
        'token'
    ];

    protected array $searchable = [
        'title'
    ];

    protected ?string $title;
    protected int $item_id;
    protected ?string $token = null;

    public function getDateTime(): ?MomentDateTime
    {
        return $this->hasOne(MomentDateTime::class, 'moment_id');
    }

    public function getLocation(): ?MomentLocation
    {
        return $this->hasOne(MomentLocation::class, 'moment_id');
    }

    public function getPeople(): array
    {
        $momentPeople = $this->hasMany(MomentPeople::class, 'moment_id');
        $userIds = array_map(fn($mp) => $mp->user_id, $momentPeople);

        return (new Profile)->whereIn('user_id', $userIds)->fetchAll();
    }

    public function syncPeople(array $user_ids = []): void
    {
        $this->syncPivot('moments_people', 'moment_id', 'user_id', $user_ids);
    }

    public function delete(): bool
    {
        $this->syncPeople();
        $this->syncTags();
        $this->getDateTime()?->delete();
        $this->getLocation()?->delete();
        $this->item->delete();
        return parent::delete();
    }

    public function render(): void
    {
        MomentTemplate::render($this);
    }
}
