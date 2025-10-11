<?php

namespace Items;

use Ivy\Abstract\Controller;

abstract class CollectionController extends Controller
{
    protected Item $item;

    protected int $item_table_id;

    public function __construct()
    {
        parent::__construct();
        $this->item = new Item();
    }

    public function save($id): void
    {
        if($this->request->request->has('delete')){
            $this->delete($id);
        } else {
            $this->update($id);
        }
    }

    abstract protected function insert($id): void;
    abstract protected function update($id): void;
    abstract protected function delete($id): void;
}