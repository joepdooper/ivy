<?php

namespace Items\Collection\Audio;

use Items\Item;
use Ivy\Abstract\Controller;
use Ivy\File;
use Ivy\Path;

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
        $this->authorize('create', $this->audio);

        $parent_id = $identifier ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
        $this->audio->populate(['file' => ''])->insert();
        $this->item->populate(['template_id' => $id, 'parent_id' => $parent_id])->insert();

        $this->flashBag->add('success', 'Audio successfully inserted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('update', $this->audio);

        $item = $this->item->where('id', $id)->fetchOne();
        $audio = $this->audio->where('id', $item->table_id)->fetchOne();

        if($this->request->files->get('audio')){
            $audio->file = $this->upload($this->request->files->get('audio'));
        }

        if($this->request->get('remove') !== null){
            $audio->unlinkFile();
        }

        $item = $this->item->where('id', $id)->fetchOne();
        $audio->update();
        $item->populate(['published' => $this->request->get('publish')])->update();

        $this->flashBag->add('success', 'Audio successfully updated');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('delete', $this->audio);

        $item = $this->item->where('id', $id)->fetchOne();
        $audio = $this->audio->where('id', $item->table_id)->fetchOne();
        $audio->unlinkFile()->delete();
        $item->delete();

        $this->flashBag->add('success', 'Audio successfully deleted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function upload($audio): ?string
    {
        $fileName = null;
        try {
            $file = new File;
            $file->setName(bin2hex(random_bytes(16)));
            $file->setAllowed(array('audio/*'));
            $file->setDirectory(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/audio');
            $fileName = $file->upload($audio);
        } catch (\Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
        }

        return $fileName;
    }
}
