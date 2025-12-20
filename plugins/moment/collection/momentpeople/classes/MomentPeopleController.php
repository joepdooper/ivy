<?php

namespace Moment\Collection\MomentPeople;

use GUMP;
use Ivy\Abstract\Controller;
use Ivy\Core\Path;
use Ivy\View\View;
use Moment\Moment;

class MomentPeopleController extends Controller
{
    private People $people;

    public function __construct()
    {
        parent::__construct();

        $this->people = new People();
    }

    public function index(): void
    {
        $this->people->policy('index');

        $people = $this->people->fetchAll();
        View::set(Path::get('PLUGINS_PATH') . 'moment/template/people.latte', ['people' => $people]);
    }

    public function post(): void
    {
        $this->people->policy('post');

        foreach ($this->request->get('people') as $data) {
            try {
                $validated = GUMP::is_valid($data, [
                    'name' => 'valid_name'
                ]);

                if ($validated !== true) {
                    foreach ($validated as $msg) $this->flashBag->add('error', $msg);
                    continue;
                }

                if (empty($data['name'])) continue;

                $people = !empty($data['id'])
                    ? People::query()->where('id', $data['id'])->fetchOne()
                    : new People();

                if (isset($data['delete']) && !empty($data['id'])) {
                    $people?->delete();
                } else {
                    $people->populate($data)->save();
                }

            } catch (\Exception $e) {
                $this->flashBag->add('error', $e->getMessage());
            }
        }

        $this->flashBag->add('success', 'Updated successful');
        $this->redirect($this->people->getPath() . DIRECTORY_SEPARATOR . 'index');
    }
}
