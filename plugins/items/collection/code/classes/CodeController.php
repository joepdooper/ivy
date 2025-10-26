<?php

namespace Items\Collection\Code;

use Items\CollectionController;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class CodeController extends CollectionController
{
    private Code $code;
    public function __construct()
    {
        parent::__construct();
        $this->code = new Code();
    }

    public function insert($id): void
    {
        $this->code->policy('create');

        $item_table_id = $this->code->populate([
            'text' => 'Write…'
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'table_id' => $item_table_id,
        ])->insert();

        $this->flashBag->add('success', 'Code successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->code->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();

        $this->code->where('id', $item->table_id)->populate([
            'code' => $this->request->get('code'),
            'language' => $this->request->get('language')
        ])->update();

        $item->populate([
            'publish' => $this->request->get('publish')
        ])->update();

        $this->flashBag->add('success', 'Code successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->code->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();
        $this->code->where('id', $item->table_id)->delete();
        $item->delete();

        $this->flashBag->add('success', 'Code successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
