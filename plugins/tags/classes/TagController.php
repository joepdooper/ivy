<?php

namespace Tags;

use GUMP;
use Ivy\Abstract\Controller;
use Ivy\Path;
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

        $tags_data = $this->request->get('tag') ?? '';

        foreach ($tags_data as $tag_data) {
            try {
                $validated = GUMP::is_valid($tag_data, [
                    'value' => 'alpha_numeric_dash'
                ]);
                if ($validated === true) {
                    $this->tag->save($tag_data);
                } else {
                    foreach ($validated as $string) {
                        $this->flashBag->add('error', $string);
                    }
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
        View::set(Path::get('PLUGIN_PATH') . 'tags/template/manage.latte', ['tags' => $tags]);
    }
}
