<?php

namespace Timeline;

use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class TimelineController extends Controller
{
    private Timeline $timeline;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->timeline = new Timeline();
        $this->item = new Item();
    }

    public function save($id): void
    {
        if($this->request->get('delete') !== null){
            $this->delete($id);
        } else {
            $this->update($id);
        }
    }

    public function insert($id): void
    {
        $this->timeline->policy('create');

        $datetime = date("Y-m-d H:i:s");

        $this->item->table_id = $this->timeline->populate([
            'datetime' => $datetime
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'slug' => ItemHelper::createSlug($datetime)
        ])->insert();

        $this->flashBag->add('success', 'Timeline successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->timeline->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->timeline->where('id', $item->table_id)->populate([
            'datetime' => $this->request->get('date') . ' ' . $this->request->get('time')
        ])->update();

        $item->populate([
            'published' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Timeline successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->timeline->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->timeline->where('id', $item->table_id)->delete();

        $item->delete();

        $this->flashBag->add('success', 'Timeline successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
