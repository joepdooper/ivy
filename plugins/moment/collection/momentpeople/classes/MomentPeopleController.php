<?php

namespace Moment\Collection\MomentPeople;

use Contacts\Contact;
use Ivy\Abstract\Controller;
use Ivy\Core\Path;
use Ivy\View\View;

class MomentPeopleController extends Controller
{
    private MomentPeople $momentPeople;

    public function __construct()
    {
        parent::__construct();

        $this->momentPeople = new MomentPeople;
    }

    public function index(): void
    {
        $this->momentPeople->policy('index');

        $people = $this->momentPeople->fetchAll();
        View::set(Path::get('PLUGINS_PATH').'moment/template/people.latte', [
            'people' => $people
        ]);
    }

    public function sync(): void
    {
        $this->people->policy('sync');

        foreach ($this->request->get('people') as $data) {
            try {
                $validated = GUMP::is_valid($data, [
                    'name' => 'valid_name',
                ]);

                if ($validated !== true) {
                    foreach ($validated as $msg) {
                        $this->flashBag->add('error', $msg);
                    }

                    continue;
                }

                if (empty($data['name'])) {
                    continue;
                }

                $people = ! empty($data['id'])
                    ? People::query()->where('id', $data['id'])->fetchOne()
                    : new People;

                if (isset($data['delete']) && ! empty($data['id'])) {
                    $people?->delete();
                } else {
                    $people->populate($data)->save();
                }

            } catch (\Exception $e) {
                $this->flashBag->add('error', $e->getMessage());
            }
        }

        $this->flashBag->add('success', 'Updated successful');
        $this->redirect($this->people->getPath().DIRECTORY_SEPARATOR.'index');
    }
}
