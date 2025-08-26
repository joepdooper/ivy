<?php

namespace Items\Collection\Image;

use Items\CollectionController;
use Items\ItemHelper;

class ImageController extends CollectionController
{
    private Image $image;

    public function __construct()
    {
        parent::__construct();
        $this->image = new Image();
    }

    public function insert($id): void
    {
        $this->image->policy('create');

        $item_table_id = $this->image->populate([
            'file' => ''
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'table_id' => $item_table_id,
        ])->insert();

        $this->flashBag->add('success', 'Image successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->image->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();
        $image = $this->image->where('id', $item->table_id)->fetchOne();

        if($this->request->files->has('image')){
            $image->file = ImageService::upload($this->request->files->get('image'));
        }

        if($this->request->get('remove') !== null){
            $image->file = ImageService::unlink($image->file);
        }

        $image->update();

        $item->populate([
            'published' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Image successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->image->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();

        $image = $this->image->where('id', $item->table_id)->fetchOne();
        ImageService::unlink($image->file);
        $image->delete();

        $item->delete();

        $this->flashBag->add('success', 'Image successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
