<?php

namespace Items\Collection\Audio;

use Items\CollectionController;
use Items\ItemHelper;
use Ivy\Service\FileService;

class AudioController extends CollectionController
{
    private Audio $audio;
    public function __construct()
    {
        parent::__construct();
        $this->audio = new Audio();
    }

    public function insert($id): void
    {
        $this->audio->policy('create');

        $item_table_id = $this->audio->populate([
            'file' => ''
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'table_id' => $item_table_id,
        ])->insert();

        $this->flashBag->add('success', 'Audio successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->audio->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();
        $audio = $this->audio->where('id', $item->table_id)->fetchOne();

        if($this->request->files->has('upload')){
            $file = new AudioFile($this->request->files->get('upload'));
            $audio->file = $file->generateFileName();

            (new FileService)->add($file)->upload();
        }

        if($this->request->request->has('remove')){
            $file = new AudioFile();
            $file->remove($audio->file);
            $audio->file = '';
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

        $this->audio->fetchOneWithItem($id)->delete();

        $this->flashBag->add('success', 'Audio successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
