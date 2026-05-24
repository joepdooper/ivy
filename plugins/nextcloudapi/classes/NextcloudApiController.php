<?php

namespace NextcloudApi;

use Ivy\Shared\Base\Controller;
use Ivy\Shared\Core\Path;
use Ivy\Template\Presentation\View\View;

class NextcloudApiController extends Controller
{
    protected NextcloudApi $nextcloudApi;

    public function __construct()
    {
        parent::__construct();
        $this->nextcloudApi = new NextcloudApi();
    }

    public function servers(): void
    {
        $this->nextcloudApi->policy('servers');

        $nextcloudApis = NextcloudApi::all();

        View::render(Path::get('PLUGINS_PATH').'nextcloudapi/template/servers.latte', [
            'nextcloudApis' => $nextcloudApis
        ]);
    }


    public function status($id): void
    {
        $this->nextcloudApi->policy('status');

        $nextcloudApi = NextcloudApi::find($id);
        $nextcloudApiClient = new NextcloudApiClient($nextcloudApi);
        $info = $nextcloudApiClient->getStatus();
        if(isset($info->data['installed'])){
            $version = $info->data['version'];
            $info = $nextcloudApiClient->getServerInfo();
            $info->version = $version;
        }
        View::render(Path::get('PLUGINS_PATH').'nextcloudapi/template/status.latte', [
            'info' => $info,
        ]);
    }
}
