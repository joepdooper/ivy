<?php

namespace NextcloudApi;

use Ivy\Shared\Base\Controller;
use Ivy\Shared\Core\Path;
use Ivy\Template\Presentation\View\View;

class NextcloudApiController extends Controller
{
    protected NextcloudApi $nextcloudApi;
    protected NextcloudApiManager $nextcloudApiManager;
    protected NextcloudApiForm $nextcloudApiForm;

    public function __construct()
    {
        parent::__construct();
        $this->nextcloudApi = new NextcloudApi();
        $this->nextcloudApiManager = new NextcloudApiManager();
        $this->nextcloudApiForm = new NextcloudApiForm();
    }

    public function add(): void
    {
        $this->nextcloudApi->policy('add');

        $data = $this->request->request->all();
        $result = $this->nextcloudApiForm->validate($data);

        if (!$result->valid) {
            $this->flashBag->set('errors', $result->errors);
            $this->flashBag->set('old', $result->old);
        } else {
            $nextcloudApi = new NextcloudApi();
            $nextcloudApi->fill($result->data)->save();
            $this->flashBag->add('success', 'Nextcloud API connection ' . $nextcloudApi->url . ' added successfully.');
        }

        $this->redirect('/admin/plugin/nextcloudapi/index');
    }

    public function update(): void
    {
        $this->nextcloudApi->policy('update');

        $data = $this->request->request->all();
        if(!$data['credentials']){
            unset($data['username']);
            unset($data['password']);
        }
        $result = $this->nextcloudApiForm->validate($data);

        if (!$result->valid) {
            $this->flashBag->set('errors', $result->errors);
            $this->flashBag->set('old', $result->old);
        } else {
            $nextcloudApi = NextcloudApi::find($data['id']);
            $nextcloudApi->fill($result->data)->save();
            $this->flashBag->add('success', 'Nextcloud API connection ' . $nextcloudApi->url . ' updated successfully.');
        }

        $this->redirect('/admin/plugin/nextcloudapi/index');
    }

    public function delete(): void
    {
        $nextcloudApi = NextcloudApi::find($this->request->request->get('delete'));

        if($nextcloudApi) {
            $nextcloudApi->policy('delete');

            $nextcloudApi->delete();
            $this->flashBag->add(
                'success',
                'Nextcloud API connection ' . $nextcloudApi->url . ' deleted successfully.'
            );
        }

        $this->redirect('/admin/plugin/nextcloudapi/index');
    }

    public function index(): void
    {
        $this->nextcloudApi->policy('index');

        $nextcloudApis = NextcloudApi::all();

        View::render(Path::get('PLUGINS_PATH').'nextcloudapi/template/index.latte', [
            'nextcloudApis' => $nextcloudApis
        ]);
    }


    public function status(int $id): void
    {
        $this->nextcloudApi->policy('status');

        $nextcloudApiClient = $this->nextcloudApiManager->get($id);
        $info = $nextcloudApiClient->getStatus();
        if(isset($info->data['installed'])){
            $version = $info->data['version'];
            $info = $nextcloudApiClient->getServerInfo();
            $info->version = $version;
        }
        View::render(Path::get('PLUGINS_PATH').'nextcloudapi/template/status.latte', [
            'id' => $id,
            'info' => $info,
        ]);
    }
}
