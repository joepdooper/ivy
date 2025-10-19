<?php

namespace Moment\Collection\MomentLocation;

use Moment\Moment;

class MomentLocationFactory
{
    public function defaults(): array
    {
        $userLocation = MomentLocationHelper::getUserLocation();

        if (!empty($userLocation['city']) && !empty($userLocation['country'])) {
            $location = $userLocation;
        } else {
            $defaults = [
                [
                    'city' => 'Amsterdam',
                    'country' => 'Netherlands',
                    'country_code' => 'NL',
                    'latitude' => 52.3676,
                    'longitude' => 4.9041,
                ],
                [
                    'city' => 'Barcelona',
                    'country' => 'Spain',
                    'country_code' => 'ES',
                    'latitude' => 41.3851,
                    'longitude' => 2.1734,
                ],
                [
                    'city' => 'London',
                    'country' => 'United Kingdom',
                    'country_code' => 'UK',
                    'latitude' => 51.5072,
                    'longitude' => -0.1276,
                ],
            ];

            $randomKey = array_rand($defaults);
            $location = $defaults[$randomKey];
        }

        return [
            'moment_id' => Moment::factory(),
            'city' => $location['city'],
            'country' => $location['country'],
            'country_code' => $location['country_code'],
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'token' => null,
        ];
    }
}
