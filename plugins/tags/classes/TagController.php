<?php

namespace Tags;

use GUMP;
use Ivy\Abstract\Controller;
use Ivy\Core\Path;
use Ivy\Model\Setting;
use Ivy\View\View;

class TagController extends Controller
{
    protected Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->tag = new Tag;
    }

    public function post(): void
    {
        $this->tag->policy('post');

        foreach ($this->request->get('tag') as $data) {
            try {
                $validated = GUMP::is_valid($data, [
                    'value' => 'alpha_numeric_dash'
                ]);

                if ($validated !== true) {
                    foreach ($validated as $msg) $this->flashBag->add('error', $msg);
                    continue;
                }

                if (empty($data['value'])) continue;

                $tag = !empty($data['id'])
                    ? (new Tag())->where('id', $data['id'])->fetchOne()
                    : new Tag();

                if (isset($data['delete']) && !empty($data['id'])) {
                    $tag?->delete();
                } else {
                    $tag->populate($data)->save();
                }

            } catch (\Exception $e) {
                $this->flashBag->add('error', $e->getMessage());
            }
        }

        $this->flashBag->add('success', 'Updated successful');
        $this->redirect($this->tag->getPath() . DIRECTORY_SEPARATOR . 'manage');
    }

    public function index(): void
    {
        $this->tag->policy('index');

        $tags = $this->tag->fetchAll();
        View::set(Path::get('PLUGINS_PATH') . 'tags/template/manage.latte', ['tags' => $tags]);
    }
}
