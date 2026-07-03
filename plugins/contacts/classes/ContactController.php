<?php

namespace Contacts;


use Illuminate\Contracts\Container\BindingResolutionException;
use Ivy\Shared\Base\Controller;
use Ivy\Shared\Core\Language;
use Ivy\Shared\Core\Path;
use Ivy\Shared\Presentation\Listing\PaginationState;
use Ivy\Template\Presentation\View\View;
use Ivy\User\Domain\Entity\Profile;
use Ivy\User\Domain\Exception\AuthorizationException;
use ReflectionException;

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

    /**
     * @throws AuthorizationException
     */
    public function index(): void
    {
        $this->contact->authorize('index');

        $contacts = Contact::with('profile.user')
            ->search($this->request)
            ->sort($this->request, 'name')
            ->pages($this->request)
            ->get();

        $profiles = Profile::whereNotExists(function ($query) {
            $query->selectRaw(1)->from('contacts')->whereColumn('contacts.profile_id', 'profiles.id');
        })->get();

        View::render(Path::get('PLUGINS_PATH').'contacts/template/index.latte', [
            'contacts' => $contacts,
            'profiles' => $profiles,
            'sort' => $this->request->query->get('sort', 'name'),
            'direction' => $this->request->query->get('direction', 'asc'),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function add(mixed $data): void
    {
        $this->contact->authorize('add');

        $contact = new Contact;

        $contact->fill($data)->save();

        $this->flashBag->add('success',
            Language::translate('contacts.contacts.added_successfully', [
                'name' => $contact->name
            ]),
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Contact|int $contact, mixed $data): void
    {
        if (is_int($contact)) {
            $contact = Contact::find($contact);
        }

        if (! $contact) {
            return;
        }

        $contact->fill($data);

        if (! $contact->isDirty()) {
            return;
        }

        $contact->authorize('update');

        $contact->save();

        $this->flashBag->add(
            'success',
            Language::translate('contacts.contacts.updated_successfully', [
                'name' => $contact->name
            ])
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(Contact|int $contact): void
    {
        if (is_int($contact)) {
            $contact = Contact::find($contact);
        }

        if (! $contact) {
            return;
        }

        $contact->authorize('delete');

        $contact->delete();

        $this->flashBag->add(
            'success',
            Language::translate('contacts.contacts.deleted_successfully', [
                'name' => $contact->name
            ])
        );
    }

    /**
     * @throws AuthorizationException
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    public function sync(): void
    {
        $this->contact->policy('sync');

        foreach ($this->request->request->all('contact') as $index => $data) {

            if (empty($data['name'])) {
                continue;
            }

            $result = $this->contactForm->validate($data);

            if ($result->valid) {
                if(empty($result->data['id'])){
                    $this->add($result->data);
                } elseif(isset($data['delete'])) {
                    $this->delete($result->data['id']);
                } else {
                    $this->update($result->data['id'], $result->data);
                }
            } else {
                $errors[$index] = $result->errors;
                $old[$index] = $result->old;
            }
        }

        if (! empty($errors) && !empty($old)) {
            $this->flashBag->set('errors', $errors);
            $this->flashBag->set('old', $old);
        }

        $this->redirect->back('admin/plugin/contacts/index');
    }
}
