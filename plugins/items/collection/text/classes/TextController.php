<?php

namespace Items\Collection\Text;

use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class TextController extends Controller
{
    private Text $text;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->text = new Text();
        $this->item = new Item();
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
        $this->authorize('create', $this->text);

        $this->item->table_id = $this->text->populate([
            'text' => 'Write…'
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request)
        ])->insert();

        $this->flashBag->add('success', 'Text successfully inserted');
        $this->redirect();
    }

    public function update($id): void
    {
        $this->authorize('update', $this->text);

        $item = $this->item->where('id', $id)->fetchOne();

        $this->text->where('id', $item->table_id)->populate([
            'text' => $this->request->get('text')
        ])->update();

        $item->populate([
            'published' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Text successfully updated');
        $this->redirect();
    }

    public function delete($id): void
    {
        $this->authorize('delete', $this->text);

        $item = $this->item->where('id', $id)->fetchOne();

        $this->text->where('id', $item->table_id)->delete();

        $item->delete();

        $this->flashBag->add('success', 'Text successfully deleted');
        $this->redirect();
    }
}
