<?php

namespace Moment;

use Items\CollectionController;
use Items\ItemHelper;
use Moment\Collection\MomentDateTime\MomentDateTime;
use Moment\Collection\MomentLocation\MomentLocation;
use Moment\Collection\MomentPeople\MomentPeople;

class MomentController extends CollectionController
{
    private Moment $moment;
    private MomentDateTime $momentDateTime;
    private MomentLocation $momentLocation;
    private MomentPeople $momentPeople;

    public function __construct()
    {
        parent::__construct();

        $this->moment = new Moment();
        $this->momentDateTime = new MomentDateTime();
        $this->momentLocation = new MomentLocation();
        $this->momentPeople = new MomentPeople();
    }

    public function insert($id = null): void
    {
        $this->moment->policy('create');

        if ($this->validate([
            'title' => 'between_len,5;100',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'start_time' => 'valid_time',
            'end_time' => 'valid_time',
            'city' => 'between_len,2;100',
            'country' => 'between_len,2;100'
        ])) {
            $this->moment->createItemFromRequest($this->request);

            $this->momentDateTime->populate([
                'moment_id' => $this->moment->getId()
            ])->createFromRequest($this->request->request->all());

            if(!empty($this->request->request->get('city')) || !empty($this->request->request->get('country'))){
                $this->momentLocation->populate([
                    'moment_id' => $this->moment->getId()
                ])->createFromRequest($this->request->request->all());
            }

            if(!empty($this->request->request->all('people'))){
                foreach ($this->request->request->all('people') as $user_id) {
                    $this->momentPeople->populate([
                        'moment_id' => $this->moment->getId(),
                        'user_id' => $user_id
                    ])->insert();
                }
            }

            $this->moment->attachTags($this->request->request->all('tags'));

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
