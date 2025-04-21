<?php

namespace Items\Collection\Image;

use Items\Item;
use Ivy\Abstract\Controller;
use Ivy\File;
use Ivy\Path;

class ImageController extends Controller
{
    private Image $image;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->image = new Image();
        $this->item = new Item();
    }

    public function save($id, $template_route = null, $identifier = null): void
    {
        if($this->request->get('delete') !== null){
            $this->delete($id, $template_route, $identifier);
        } else {
            $this->update($id, $template_route, $identifier);
        }
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('create', $this->image);

        $parent_id = $identifier ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
        $this->image->populate(['file' => ''])->insert();
        $this->item->populate(['template_id' => $id, 'parent_id' => $parent_id])->insert();

        $this->flashBag->add('success', 'Image successfully inserted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('update', $this->image);

        $item = $this->item->where('id', $id)->fetchOne();
        $image = $this->image->where('id', $item->table_id)->fetchOne();

        if($this->request->files->has('image')){
            $image->file = ImageService::upload($this->request->files->get('image'));
        }

        if($this->request->get('remove') !== null){
            $image->file = ImageService::unlink($image->file);
        }

        $image->update();
        $item->populate(['published' => $this->request->get('publish')])->update();

        $this->flashBag->add('success', 'Image successfully updated');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('delete', $this->image);

        $item = $this->item->where('id', $id)->fetchOne();
        $image = $this->image->where('id', $item->table_id)->fetchOne();
        ImageService::unlink($image->file);
        $image->delete();
        $item->delete();

        $this->flashBag->add('success', 'Image successfully deleted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }
}
