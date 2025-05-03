<?php

namespace Items\Collection\Documentation;

use Items\Collection\Image\ImageService;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;
use Tag\Tag;

class DocumentationController extends Controller
{
    private Documentation $documentation;
    private Item $item;
    private Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->documentation = new Documentation();
        $this->item = new Item();
        $this->tag = new Tag();
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
        $this->authorize('create', $this->documentation);

        $this->item->table_id = $this->documentation->populate([
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'subject' => $this->tag->fetchOne()->getId()
        ])->insert();

        $this->item->id = $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'slug' => ItemHelper::createSlug('Title')
        ])->insert();

        $this->documentation->where('id', $this->item->table_id)->populate([
            'item_id' => $this->item->id,
        ])->update();

        $this->flashBag->add('success', 'Documentation successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->authorize('update', $this->documentation);

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
            'published' => $this->request->get('publish'),
        ])->update();

        $this->flashBag->add('success', 'Documentation successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->authorize('delete', $this->documentation);

        $item = $this->item->where('id', $id)->fetchOne();
        $this->documentation->where('id', $item->table_id)->delete();
        $item->delete();

        $this->flashBag->add('success', 'Documentation successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
