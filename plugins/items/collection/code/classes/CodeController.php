<?php

namespace Items\Collection\Code;

use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class CodeController extends Controller
{
    private Code $code;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->code = new Code();
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
        $this->code->policy('create');

        $this->item->table_id = $this->code->populate([
            'code' => 'Insert code…',
            'language' => 'php'
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request)
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
            'published' => $this->request->get('publish')
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
