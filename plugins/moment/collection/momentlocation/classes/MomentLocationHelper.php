<?php

namespace Moment\Collection\MomentLocation;

use Ivy\Manager\SessionManager;
use Curl\Curl;

class MomentLocationHelper
{
    public static function getUserIp(): string
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'] as $key) {
            if (!empty($_SERVER[$key])) {
                $ipList = explode(',', $_SERVER[$key]);
                return trim($ipList[0]);
            }
        }
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    public static function getUserLocation(string $ip = null): array
    {
        $cacheKey = 'user_location';

        if (SessionManager::has($cacheKey)) {
            return SessionManager::get($cacheKey);
        }

        $ip = $ip ?? self::getUserIp();
        $url = "http://ip-api.com/json/{$ip}?fields=status,message,country,countryCode,city,lat,lon";

        $curl = new Curl();
        $curl->setTimeout(2);
        $curl->get($url);

        if ($curl->error || !isset($curl->response->status) || $curl->response->status !== 'success') {
            $location = [
                'city' => null,
                'country' => null,
                'country_code' => null,
                'latitude' => null,
                'longitude' => null,
            ];
        } else {
            $location = [
                'city' => $curl->response->city ?? null,
                'country' => $curl->response->country ?? null,
                'country_code' => $curl->response->countryCode ?? null,
                'latitude' => $curl->response->lat ?? null,
                'longitude' => $curl->response->lon ?? null,
            ];
        }

        SessionManager::set($cacheKey, $location);

        return $location;
    }
}