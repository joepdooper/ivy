<?php

namespace Tags;

use Illuminate\Contracts\Container\BindingResolutionException;
use Ivy\Shared\Base\Controller;
use Ivy\Shared\Core\Path;
use Ivy\Template\Presentation\View\View;
use Ivy\User\Domain\Exception\AuthorizationException;
use ReflectionException;

class TagController extends Controller
{
    protected Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->tag = new Tag;
    }

    public function index(): void
    {
        $this->tag->policy('index');

        $tags = Tag::all();
        View::render(Path::get('PLUGINS_PATH').'tags/template/manage.latte', ['tags' => $tags]);
    }

    /**
     * @throws AuthorizationException
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    public function sync(): void
    {
        $this->tag->policy('sync');

        foreach ($this->request->get('tag') as $data) {
            try {
                $validated = GUMP::is_valid($data, [
                    'value' => 'alpha_numeric_dash',
                ]);

                if ($validated !== true) {
                    foreach ($validated as $msg) {
                        $this->flashBag->add('error', $msg);
                    }

                    continue;
                }

                if (empty($data['value'])) {
                    continue;
                }

                $tag = ! empty($data['id'])
                    ? (new Tag)->where('id', $data['id'])->fetchOne()
                    : new Tag;

                if (isset($data['delete']) && ! empty($data['id'])) {
                    $tag?->delete();
                } else {
                    $tag->populate($data)->save();
                }

            } catch (\Exception $e) {
                $this->flashBag->add('error', $e->getMessage());
            }
        }

        $this->flashBag->add('success', 'Updated successful');
        $this->redirect('/admin/plugin/tags/manage');
    }
}
