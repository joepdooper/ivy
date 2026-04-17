<?php

namespace Contacts;

use Ivy\Abstract\Controller;
use Ivy\Core\Path;
use Ivy\View\View;

class ContactController extends Controller
{
    protected Contact $contact;
    protected ContactForm $contactForm;

    public function __construct()
    {
        parent::__construct();
        $this->contact = new Contact;
        $this->contactForm = new ContactForm();
    }

    public function index(): void
    {
        $this->contact->policy('index');

        $contacts = $this->contact->fetchAll();
        View::set(Path::get('PLUGINS_PATH').'contacts/template/index.latte', ['contacts' => $contacts]);
    }

    public function add(mixed $data): void
    {
        $contact = new Contact;

        $contact->authorize('add');

        $contact->populate($data)->save();
        $this->flashBag->add('success', 'Contact ' . $contact->name . ' added successfully.');
    }

    public function update(Contact|int $contact, mixed $data): void
    {
        if(is_int($contact)) {
            $contact = (new Contact)->where('id', $contact)->fetchOne();
        }

        $contact?->authorize('update');

        if($contact && $contact->isDirty($data)) {
            $contact->populate($data)->update();
            $this->flashBag->add('success', 'Contact ' . $contact->name . ' updated successfully.');
        }
    }

    public function delete(Contact|int $contact): void
    {
        if(is_int($contact)) {
            $contact = (new Contact)->where('id', $contact)->fetchOne();
        }

        $contact?->authorize('delete');

        if($contact){
            $contact->delete();
            $this->flashBag->add('success', 'Contact ' . $contact->name . ' deleted successfully.');
        }
    }

    public function sync(): void
    {
        $this->contact->policy('sync');

        foreach ($this->request->get('contact') as $index => $data) {

            if (empty($data['name'])) {
                continue;
            }

            $result = $this->contactForm->validate($data);

            if ($result->valid) {
                if(empty($data['id'])){
                    $this->add($data);
                } elseif(isset($data['delete'])) {
                    $this->delete($data['id']);
                } else {
                    $this->update($data['id'], $data);
                }
            } else {
                $errors[$index] = $result->errors;
                $old[$index] = $result->old;
            }
        }

        $this->redirect($this->contact->getPath().DIRECTORY_SEPARATOR.'index');
    }
}
