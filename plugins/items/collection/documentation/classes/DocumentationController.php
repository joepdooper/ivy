<?php

namespace Items\Collection\Documentation;

use Items\Collection\Image\ImageService;
use Items\CollectionController;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;
use Tags\Tag;

class DocumentationController extends CollectionController
{
    private Documentation $documentation;
    private Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->documentation = new Documentation();
        $this->tag = new Tag();
    }

    public function insert($id): void
    {
        $this->documentation->policy('create');

        $this->item->table_id = $this->documentation->populate([
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'subject' => $this->tag->fetchOne()->getId()
        ])->insert();

        $item_id = $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'slug' => ItemHelper::createSlug('Title')
        ])->insert();

        $this->documentation->where('id', $table_id)->populate([
            'item_id' => $item_id,
        ])->update();

        $this->flashBag->add('success', 'Documentation successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->documentation->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();
        $documentation = $this->documentation->where('id', $item->table_id)->fetchOne();

        if($this->request->request->has('title')){
            $documentation->title = $this->request->request->get('title');
        }
        if($this->request->request->has('subtitle')){
            $documentation->subtitle = $this->request->request->get('subtitle');
        }
        if($this->request->request->has('tag')){
            $documentation->subject = $this->request->request->get('tag');
        }

        $documentation->update();

        if($this->request->request->has('datetime')){
            $item->date = $this->request->request->get('datetime');
        }

        $item->populate([
            'slug' => ItemHelper::createSlug($documentation->title),
            'published' => $this->request->get('publish'),
        ])->update();

        $this->flashBag->add('success', 'Documentation successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->documentation->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();
        $this->documentation->where('id', $item->table_id)->delete();
        $item->delete();

        $this->flashBag->add('success', 'Documentation successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
