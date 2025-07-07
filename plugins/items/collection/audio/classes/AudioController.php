<?php

namespace Items\Collection\Audio;

use Items\Collection\Image\ImageService;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class AudioController extends Controller
{
    private Audio $audio;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->audio = new Audio();
        $this->item = new Item();
    }

    public function insert($id): void
    {
        $this->audio->policy('create');

        $this->item->table_id = $this->audio->populate([
            'file' => ''
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request)
        ])->insert();

        $this->flashBag->add('success', 'Audio successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->audio->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();
        $audio = $this->audio->where('id', $item->table_id)->fetchOne();

        if($this->request->files->get('audio')){
            $audio->file = ImageService::upload($this->request->files->get('audio'));
        }

        if($this->request->get('remove') !== null){
            AudioService::unlink($audio->file);
        }

        $audio->update();

        $item->populate([
            'published' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Audio successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->audio->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();

        $audio = $this->audio->where('id', $item->table_id)->fetchOne();
        AudioService::unlink($audio->file);
        $audio->delete();

        $item->delete();

        $this->flashBag->add('success', 'Audio successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
