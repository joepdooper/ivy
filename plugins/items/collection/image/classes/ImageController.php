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
            $file = new ImageFile($this->request->files->get('image'));
            $image->file = $file->process()->getFileName();
        }

        if($this->request->get('remove') !== null){
            $file = new ImageFile();
            $file->remove($image->file);
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

        $this->image->fetchOneWithItem($id)->delete();
        $this->flashBag->add('success', 'Image successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
