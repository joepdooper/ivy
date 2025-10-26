<?php

namespace Items\Collection\Text;

use Items\CollectionController;
use Items\ItemHelper;

class TextController extends CollectionController
{
    private Text $text;

    public function __construct()
    {
        parent::__construct();
        $this->text = new Text();
    }

    public function insert($id): void
    {
        $this->text->policy('create');

        $item_table_id = $this->text->populate([
            'text' => 'Write…'
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'table_id' => $item_table_id,
        ])->insert();

        $this->flashBag->add('success', 'Text successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->text->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->text->where('id', $item->table_id)->populate([
            'text' => $this->request->get('text')
        ])->update();

        $item->populate([
            'publish' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Text successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->text->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->text->where('id', $item->table_id)->delete();

        $item->delete();

        $this->flashBag->add('success', 'Text successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
