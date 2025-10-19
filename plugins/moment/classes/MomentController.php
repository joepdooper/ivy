<?php

namespace Moment;

use Items\CollectionController;
use Items\ItemHelper;
use Ivy\Model\User;
use Moment\Collection\MomentDateTime\MomentDateTime;
use Moment\Collection\MomentLocation\MomentLocation;
use Moment\Collection\MomentPeople\MomentPeople;
use Tags\Tag;

class MomentController extends CollectionController
{
    private Tag $tag;
    private Moment $moment;
    private MomentDateTime $momentDateTime;
    private MomentLocation $momentLocation;
    private MomentPeople $momentPeople;

    public function __construct()
    {
        parent::__construct();
        $this->tag = new Tag();
        $this->moment = new Moment();
        $this->momentDateTime = new MomentDateTime();
        $this->momentLocation = new MomentLocation();
        $this->momentPeople = new MomentPeople();
    }

    public function insert($id = null): void
    {
        $this->moment->policy('create');

        if ($this->validate([
            'title' => 'string',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'start_time' => 'valid_time',
            'end_time' => 'valid_time'
        ])) {
            $this->moment->createItemFromRequest($this->request);

            $this->momentDateTime->populate([
                'moment_id' => $this->moment->getId()
            ])->createFromRequest($this->request->request->all());
            $this->momentLocation->populate([
                'moment_id' => $this->moment->getId()
            ])->createFromRequest($this->request->request->all());

            $this->momentPeople->populate([
                'moment_id' => $this->moment->getId(),
                'user_id' => User::getAuth()->getUserId()
            ])->insert();

            $this->moment->attachTag($this->tag->where('value', 'Moment')->fetchOne()->getId());

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
            'title' => 'string',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'start_time' => 'valid_time',
            'end_time' => 'valid_time',
        ])) {
            $moment = $this->moment->fetchOneWithItem($id);
            $moment->updateItemFromRequest($this->request);
            $moment->getDateTime()->updateFromRequest($this->request->request->all());
            $moment->getLocation()->updateFromRequest($this->request->request->all());

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
