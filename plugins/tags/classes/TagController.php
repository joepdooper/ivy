<?php

namespace Tags;

use Ivy\Shared\Base\Controller;
use Ivy\Shared\Core\Path;
use Ivy\Template\Presentation\View\View;
use Ivy\User\Domain\Exception\AuthorizationException;


class TagController extends Controller
{
    protected Tag $tag;
    protected TagForm $tagForm;

    public function __construct()
    {
        parent::__construct();
        $this->tag = new Tag;
        $this->tagForm = new TagForm;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): void
    {
        $this->tag->authorize('index');

        $tags = Tag::all()->sortBy('value');

        View::render(Path::get('PLUGINS_PATH').'tags/template/index.latte', [
            'tags' => $tags
        ]);
    }

    public function add(mixed $data): void
    {
        $tag = new Tag();

        $tag->authorize('add');

        $tag->fill($data)->save();

        $this->flashBag->add(
            'success',
            'Tag ' . $tag->value . ' added successfully.'
        );
    }

    public function update(Tag|int $tag, mixed $data): void
    {
        if (is_int($tag)) {
            $tag = Tag::find($tag);
        }

        if (! $tag) {
            return;
        }

        $tag->fill($data);

        if (! $tag->isDirty()) {
            return;
        }

        $tag->authorize('update');

        $tag->save();

        $this->flashBag->add(
            'success',
            'Tag ' . $tag->value . ' updated successfully.'
        );
    }

    public function delete(Tag|int $tag): void
    {
        if (is_int($tag)) {
            $tag = Tag::find($tag);
        }

        $tag?->authorize('delete');

        if ($tag) {
            $tag->delete();

            $this->flashBag->add(
                'success',
                'Tag ' . $tag->value . ' deleted successfully.'
            );
        }
    }

    public function sync(): void
    {
        $this->tag->policy('sync');

        $errors = $old = [];

        foreach ($this->request->request->get('tag') as $index => $data) {

            if (empty($data['value'])) {
                continue;
            }

            $result = $this->tagForm->validate($data);

            if ($result->valid) {

                if (empty($result->data['id'])) {
                    $this->add($result->data);

                } elseif (isset($result->data['delete'])) {
                    $this->delete($result->data['id']);

                } else {
                    $this->update($result->data['id'], $result->data);
                }

            } else {
                $errors[$index] = $result->errors;
                $old[$index] = $result->old;
            }
        }

        if (! empty($errors)) {
            $this->flashBag->set('errors', $errors);
            $this->flashBag->set('old', $old);
        }

        $this->redirect('/admin/plugin/tags/index');
    }
}
