<?php

namespace Items\Collection\Youtube;

use Items\CollectionController;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class YoutubeController extends CollectionController
{
    private Youtube $youtube;

    public function __construct()
    {
        parent::__construct();
        $this->youtube = new Youtube();
    }

    public function insert($id): void
    {
        $this->youtube->policy('create');

        $table_id = $this->youtube->populate([
            'youtube_video_id' => 'aKydtOXW8mI'
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request)
        ])->insert();

        $this->flashBag->add('success', 'Youtube successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->youtube->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->youtube->where('id', $item->table_id)->populate([
            'youtube_video_id' => $this->request->get('youtube_video_id')
        ])->update();

        $item->populate([
            'published' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Youtube successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->youtube->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->youtube->where('id', $item->table_id)->delete();

        $item->delete();

        $this->flashBag->add('success', 'Youtube successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
