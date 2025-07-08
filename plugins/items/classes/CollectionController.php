<?php

namespace Items;

use Ivy\Abstract\Controller;

abstract class CollectionController extends Controller
{
    protected Item $item;

    public function __construct()
    {
        parent::__construct();
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

    abstract protected function insert($id): void;
    abstract protected function update($id): void;
    abstract protected function delete($id): void;

    abstract protected function getModel(): object;
    abstract protected function getInsertData(): array;
    abstract protected function getUpdateData(): array;
}