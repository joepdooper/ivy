<?php

namespace Tags;

trait TagTrait
{
    public function tags(): array
    {
        return $this->belongsToMany(
            Tag::class,
            'entity_tags',
            foreignPivotKey: '',
            relatedPivotKey: 'tag_id',
            morphType: 'entity_table',
            morphId: 'entity_id'
        );
    }

    public function attachTag(int $tag_id): void
    {
        $this->attachPivot(
            'entity_tags',
            foreignPivotKey: '',
            relatedPivotKey: 'tag_id',
            relatedId: $tag_id
        );
    }

    public function detachTag(int $tag_id): void
    {
        $this->detachPivot(
            'entity_tags',
            foreignPivotKey: '',
            relatedPivotKey: 'tag_id',
            relatedId: $tag_id
        );
    }

    public function syncTags(array $tag_ids = []): void
    {
        $this->syncPivot(
            'entity_tags',
            foreignPivotKey: '',
            relatedPivotKey: 'tag_id',
            relatedIds: $tag_ids,
            morphType: 'entity_table',
            morphId: 'entity_id'
        );
    }
}
