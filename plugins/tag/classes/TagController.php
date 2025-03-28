<?php

namespace Tag;

use GUMP;
use Ivy\Abstract\Controller;
use Ivy\Path;
use Ivy\View\LatteView;

class TagController extends Controller
{
    protected Tag $tag;

    public function post(): void
    {
        $this->authorize('post', Tag::class);

        $tags_data = $this->request->get('tag') ?? '';

        foreach ($tags_data as $tag_data) {
            try {
                $validated = GUMP::is_valid($tag_data, [
                    'value' => 'alpha_numeric_dash'
                ]);
                if ($validated === true) {
                    $this->tag = new Tag;
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
        $this->redirect($this->tag->path . DIRECTORY_SEPARATOR . 'manage');
    }

    public function index(): void
    {
        $this->authorize('index', Tag::class);

        $tags = (new Tag)->fetchAll();
        LatteView::set(Path::get('PLUGIN_PATH') . 'tag/template/manage.latte', ['tags' => $tags]);
    }
}
