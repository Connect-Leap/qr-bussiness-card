<?php

namespace App\Http\Resources;

use Jenssegers\Agent\Agent;
use App\Traits\ClientIp;

class QrProcessingResource
{
    use ClientIp;

    public function toArray($qr_visitor_data)
    {
        $agent = new Agent();

        return [
            'visitor_location_data' => [
                'ip_address' => $this->getIp(),
                'country_name' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->countryName,
                'country_code' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->countryCode,
                'region_code' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->regionCode,
                'region_name' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->regionName,
                'city_name' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->cityName,
                'zip_code' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->zipCode,
                'latitude' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->latitude,
                'longitude' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->longitude,
                'area_code' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->areaCode,
                'timezone' => ($qr_visitor_data == false) ? 'On Local Development' : $qr_visitor_data->timezone,
            ],
            'visitor_internet_data' => [
                'device_name' => $agent->device(),
                'operating_system_name' => $agent->platform(),
                'browser_name' => $agent->browser(),
                'is_robot' => $agent->isRobot(),
                'robot_name' => $agent->robot(),
            ],
        ];
    }
}
