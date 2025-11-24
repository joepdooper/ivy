<?php

namespace Moment;

use Items\CollectionController;
use Items\ItemHelper;
use Moment\Collection\MomentDateTime\MomentDateTime;
use Moment\Collection\MomentLocation\MomentLocation;

class MomentController extends CollectionController
{
    private Moment $moment;

    private array $rules = [
        'title' => 'between_len,5;100',
        'start_date' => 'required|date',
        'end_date' => 'date',
        'start_time' => 'valid_time',
        'end_time' => 'valid_time',
        'city' => 'between_len,2;100',
        'country' => 'between_len,2;100'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->moment = new Moment();
    }

    public function insert($id = null): void
    {
        $this->moment->policy('create');

        if ($this->validate($this->rules)) {
            $this->moment->createItemFromRequest($this->request);

            (new MomentDateTime)->populate([
                'moment_id' => $this->moment->getId()
            ])->createFromRequest($this->request->request->all());

            if(!empty($this->request->request->get('city')) || !empty($this->request->request->get('country'))){
                (new MomentLocation)->populate([
                    'moment_id' => $this->moment->getId()
                ])->createFromRequest($this->request->request->all());
            }

            $this->moment->syncPeople($this->request->request->all('people'));
            $this->moment->syncTags($this->request->request->all('tags'));

            $this->flashBag->add('success', 'Moment successfully inserted');
        }

        $this->redirect(ItemHelper::getRedirect($this->request, $this->moment->item));
    }

    public function create(): void
    {
        $this->insert();
    }

    public function update($id): void
    {
        $this->moment->policy('update');

        if ($this->validate($this->rules)) {
            $moment = $this->moment->with(['item'])->where('item_id', $id)->fetchOne();
            $moment->updateItemFromRequest($this->request);
            $moment->getDateTime()->updateFromRequest($this->request->request->all());

            if(empty($this->request->request->get('city')) && empty($this->request->request->get('country'))) {
                !$moment->getLocation() || $moment->getLocation()->delete();
            }

            if((!empty($this->request->request->get('city')) || !empty($this->request->request->get('country'))) && (!empty($this->request->request->get('latitude')) && !empty($this->request->request->get('longitude')))) {
                if($moment->getLocation()){
                    $moment->getLocation()->updateFromRequest($this->request->request->all());
                } else {
                    (new MomentLocation)->populate([
                        'moment_id' => $moment->getId()
                    ])->createFromRequest($this->request->request->all());
                }
            }

            $moment->syncPeople($this->request->request->all('people'));
            $moment->syncTags($this->request->request->all('tags'));

            $this->flashBag->add('success', 'Moment successfully updated');
        }

        $this->redirect(ItemHelper::getRedirect($this->request, $moment->item));
    }

    public function delete($id): void
    {
        $this->moment->policy('delete');

        $moment = $this->moment->with(['item'])->where('id', $id)->fetchOne();

        $moment->syncPeople();
        $moment->syncTags();

        $moment->getDateTime()->delete();
        $moment->getLocation()->delete();

        $moment->delete();

        $this->flashBag->add('success', 'Moment successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
