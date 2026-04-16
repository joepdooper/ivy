<?php

namespace Contacts;

use Ivy\Abstract\Controller;
use Ivy\Core\Path;
use Ivy\View\View;

class ContactController extends Controller
{
    protected Contact $contact;

    public function __construct()
    {
        parent::__construct();
        $this->contact = new Contact;
    }

    public function index(): void
    {
        $this->contact->policy('index');

        $contacts = $this->contact->fetchAll();
        View::set(Path::get('PLUGINS_PATH').'contacts/template/index.latte', ['contacts' => $contacts]);
    }

    public function sync(): void
    {
        $this->contact->policy('sync');

        d($this->request->get('contact'));die;

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
        $this->redirect($this->tag->getPath().DIRECTORY_SEPARATOR.'manage');
    }
}
