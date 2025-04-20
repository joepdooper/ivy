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

        if($this->request->files->get('image')){
            $image->file = $this->upload($this->request->files->get('image'));
        }

        if($this->request->get('remove') !== null){
            $image->unlinkFile();
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
        $image->unlinkFile()->delete();
        $item->delete();

        $this->flashBag->add('success', 'Image successfully deleted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function upload($image): ?string
    {
        $fileName = null;
        try {
            $file = new File;
            $file->setName(bin2hex(random_bytes(16)));
            $file->setAllowed(array('image/*'));
            foreach ((new ImageSize)->fetchAll() as $size) {
                if($size->value){
                    $file->setWidth($size->value);
                }
                $file->setDirectory(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/' . $size->name);
                $fileName = $file->upload($image);
                $file->setImageConvert( 'webp');
                $file->upload($image);
            }
        } catch (\Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
        }

        return $fileName;
    }
}
