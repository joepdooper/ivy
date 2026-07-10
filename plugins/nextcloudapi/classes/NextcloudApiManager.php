<?php

namespace NextcloudApi;

class NextcloudApiManager
{
    protected array $clients = [];

    public function get(string $id): NextcloudApiClient
    {
        if (! isset($this->clients[$id])) {
            $this->clients[$id] = new NextcloudApiClient(NextcloudApi::find($id));
        }

        return $this->clients[$id];
    }
}
