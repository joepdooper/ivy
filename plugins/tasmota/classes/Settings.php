<?php

namespace Tasmota;

use Curl\Curl;
use Ivy\Model;

class Settings extends Model
{
    public int $id;
    public string $ip;
    public string $token;
    public int $subject;

    protected string $table = "tasmota";
    protected string $path = 'plugin/tasmota';

    function device($ip, $cmnd)
    {
        $curl = new Curl();
        $curl->get('https://' . $ip . '/cm?cmnd=' . $cmnd);
        if ($curl->error) {
            return 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
        } else {
            return $curl->response;
        }
    }

}
