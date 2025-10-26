<?php

namespace Tags;

use Delight\Db\Throwable\EmptyWhereClauseError;
use Ivy\Manager\DatabaseManager;

trait TagTrait
{
    /**
     * Fetch all tags linked to this model instance.
     *
     * @return Tag[]
     */
    public function fetchAllEntityTags(): array
    {
        $tagModel = new Tag();

        return $tagModel
            ->addJoin('entity_tags', 'id', '=', 'tag_id')
            ->where('entity_tags.entity_table', $this->table)
            ->where('entity_tags.entity_id', $this->id)
            ->fetchAll();
    }

    /**
     * Add a tag to this model instance.
     *
     * @param int $tag_id
     * @return bool Insert success
     */
    public function attachTag(int $tag_id): bool
    {
        try {
            DatabaseManager::connection()->insert('entity_tags', [
                'tag_id' => $tag_id,
                'entity_table' => $this->table,
                'entity_id' => $this->id
            ]);
            return true;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Add multiple tags to this model instance.
     *
     * @param int[] $tag_ids
     * @return int Number of successfully attached tags
     */
    public function attachTags(array $tag_ids): int
    {
        $count = 0;

        foreach ($tag_ids as $tag_id) {
            if (!is_numeric($tag_id)) {
                continue;
            }

            if ($this->attachTag((int) $tag_id)) {
                $count++;
            }
        }

        return $count;
    }


    /**
     * Remove a tag from this model instance.
     *
     * @param int $tag_id
     * @return int Number of deleted rows
     * @throws EmptyWhereClauseError
     */
    public function detachTag(int $tag_id): int
    {
        return DatabaseManager::connection()->delete('entity_tags', [
            'tag_id' => $tag_id,
            'entity_table' => $this->table,
            'entity_id' => $this->id
        ]);
    }
}