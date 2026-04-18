<?php

namespace Contacts;

use Ivy\Abstract\Controller;
use Ivy\Core\Path;
use Ivy\Model\Profile;
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
        $profiles = (new Profile)->whereNotIn('id',
            (new Contact)
            ->whereNot('profile_id', null)
            ->pluck('profile_id')
        )->fetchAll();
        View::set(Path::get('PLUGINS_PATH').'contacts/template/index.latte', [
            'contacts' => $contacts,
            'profiles' => $profiles
        ]);
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

        if($contact && $contact->isDirty($data)) {
            $contact->authorize('update');
            $contact->populate($data);
            if($contact->profile_id && !$contact->email){
                $contact->email = $contact->profile->user->email;
            }
            $contact->update();
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
                if(empty($result->data['id'])){
                    $this->add($result->data);
                } elseif(isset($result->data['delete'])) {
                    $this->delete($result->data['id']);
                } else {
                    $this->update($result->data['id'], $result->data);
                }
            } else {
                $errors[$index] = $result->errors;
                $old[$index] = $result->old;
            }
        }

        $this->redirect($this->contact->getPath().DIRECTORY_SEPARATOR.'index');
    }
}
