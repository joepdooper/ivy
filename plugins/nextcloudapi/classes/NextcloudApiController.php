<?php

namespace NextcloudApi;

use Ivy\Shared\Base\Controller;
use Ivy\Shared\Core\Path;
use Ivy\Template\Presentation\View\View;
use Ivy\User\Domain\Exception\AuthorizationException;

class NextcloudApiController extends Controller
{
    protected NextcloudApi $nextcloudApi;

    protected NextcloudApiManager $nextcloudApiManager;

    protected NextcloudApiForm $nextcloudApiForm;

    public function __construct()
    {
        parent::__construct();
        $this->nextcloudApi = new NextcloudApi;
        $this->nextcloudApiManager = new NextcloudApiManager;
        $this->nextcloudApiForm = new NextcloudApiForm;
    }

    /**
     * @throws AuthorizationException
     */
    public function add(): void
    {
        $this->nextcloudApi->authorize('add');

        $data = $this->request->request->all();
        $result = $this->nextcloudApiForm->validate($data);

        if (! $result->valid) {
            $this->flashBag->set('errors', $result->errors);
            $this->flashBag->set('old', $result->old);
        } else {
            $nextcloudApi = new NextcloudApi;
            $nextcloudApi->fill($result->data)->save();
            $this->flashBag->add('success', 'Nextcloud API connection '.$nextcloudApi->url.' added successfully.');
        }

        $this->redirect('/admin/plugin/nextcloudapi/index');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(): void
    {
        $this->nextcloudApi->authorize('update');

        $data = $this->request->request->all();
        if (! $data['credentials']) {
            unset($data['username']);
            unset($data['password']);
        }
        $result = $this->nextcloudApiForm->validate($data);

        if (! $result->valid) {
            $this->flashBag->set('errors', $result->errors);
            $this->flashBag->set('old', $result->old);
        } else {
            $nextcloudApi = NextcloudApi::find($data['id']);
            $nextcloudApi->fill($result->data)->save();
            $this->flashBag->add('success', 'Nextcloud API connection '.$nextcloudApi->url.' updated successfully.');
        }

        $this->redirect('/admin/plugin/nextcloudapi/index');
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(): void
    {
        $nextcloudApi = NextcloudApi::find($this->request->request->get('delete'));

        if ($nextcloudApi) {
            $nextcloudApi->authorize('delete');

            $nextcloudApi->delete();
            $this->flashBag->add(
                'success',
                'Nextcloud API connection '.$nextcloudApi->url.' deleted successfully.'
            );
        }

        $this->redirect('/admin/plugin/nextcloudapi/index');
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): void
    {
        $this->nextcloudApi->authorize('index');

        $nextcloudApis = NextcloudApi::all();

        View::render(Path::get('PLUGINS_PATH').'nextcloudapi/template/index.latte', [
            'nextcloudApis' => $nextcloudApis,
        ]);
    }

    public function response(): void
    {
        $nextcloudApis = NextcloudApi::all();

        foreach ($nextcloudApis as $nextcloudApi) {
            try {
                $nextcloudApiClient = $this->nextcloudApiManager->get($nextcloudApi->id);
                $nextcloudApi->response = $nextcloudApiClient->getStatus();
                if (isset($nextcloudApi->response->data['installed'])) {
                    $nextcloudApi->response = $nextcloudApiClient->getServerInfo();
                }
            } catch (\Throwable $e) {
                $nextcloudApi->status = (object) [
                    'code' => 'TIMEOUT',
                    'message' => $e->getMessage(),
                ];
            }
        }

        View::render(Path::get('PLUGINS_PATH').'nextcloudapi/template/response.latte', [
            'nextcloudApis' => $nextcloudApis,
        ]);
    }
}
