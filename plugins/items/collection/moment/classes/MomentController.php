<?php

namespace Items\Collection\Moment;

use Items\CollectionController;
use Items\ItemHelper;

class MomentController extends CollectionController
{
    private Moment $moment;

    public function __construct()
    {
        parent::__construct();
        $this->moment = new Moment();
    }

    public function insert($id = null): void
    {
        $this->moment->policy('create');

        if ($this->validate([
            'title' => 'required|max_len,100|min_len,3',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'start_time' => 'time',
            'end_time' => 'time',
        ])) {
            $this->moment->createItemFromRequest($this->request);
            $this->flashBag->add('success', 'Moment successfully inserted');
        }

        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function create(): void
    {
        $this->insert();
    }

    public function update($id): void
    {
        $this->moment->policy('update');

        if ($this->validate([
            'title' => 'required|max_len,100|min_len,3',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'start_time' => 'time',
            'end_time' => 'time',
        ])) {
            $this->moment->fetchOneWithItem($id);
            $this->moment->updateItemFromRequest($this->request);
            $this->flashBag->add('success', 'Moment successfully updated');
        }

        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->moment->policy('delete');

        $this->moment->fetchOneWithItem($id)->delete();

        $this->flashBag->add('success', 'Moment successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
