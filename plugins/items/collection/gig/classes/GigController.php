<?php

namespace Items\Collection\Gig;

use Items\Collection\Image\ImageService;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;
use Tag\Tag;

class GigController extends Controller
{
    private Gig $gig;
    private Item $item;
    private Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->gig = new Gig();
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
        $this->authorize('create', $this->gig);

        $this->item->table_id = $this->gig->populate([
            'datetime' => date("Y-m-d H:i:s"),
            'venue' => 'Venue',
            'address' => 'Address',
            'subject' => $this->tag->fetchOne()->getId()
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'slug' => ItemHelper::createSlug('Title')
        ])->insert();

        $this->flashBag->add('success', 'Gig successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->authorize('update', $this->gig);

        $item = $this->item->where('id', $id)->fetchOne();
        $gig = $this->gig->where('id', $item->table_id)->fetchOne();

        $gig->populate([
            'datetime' => $this->request->get('date') . ' ' . $this->request->get('time'),
            'venue' => $this->request->get('venue'),
            'address' => $this->request->get('address'),
            'subject' => $this->request->get('tag')
        ])->update();

        $item->populate([
            'published' => $this->request->get('publish'),
        ])->update();

        $this->flashBag->add('success', 'Gig successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->authorize('delete', $this->gig);

        $item = $this->item->where('id', $id)->fetchOne();

        $this->gig->where('id', $item->table_id)->delete();

        $item->delete();

        $this->flashBag->add('success', 'Gig successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
