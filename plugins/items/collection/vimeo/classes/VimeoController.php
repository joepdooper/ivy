<?php

namespace Items\Collection\Vimeo;

use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class VimeoController extends Controller
{
    private Vimeo $vimeo;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->vimeo = new Vimeo();
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
        $this->vimeo->policy('create');

        $this->item->table_id = $this->vimeo->populate([
            'vimeo_video_id' => '876176995'
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request)
        ])->insert();

        $this->flashBag->add('success', 'Vimeo successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->vimeo->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->vimeo->where('id', $item->table_id)->populate([
            'vimeo_video_id' => $this->request->get('vimeo_video_id')
        ])->update();

        $item->populate([
            'published' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Vimeo successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->vimeo->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->vimeo->where('id', $item->table_id)->delete();

        $item->delete();

        $this->flashBag->add('success', 'Vimeo successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
