<?php

namespace App\IMEI_Lookup;

use Illuminate\Http\Request;

trait IMEI_Lookup
{
    public function lookUpIMEI($array)
    {
        if (isset($array['serial']) && $array['serial'] !== '' && isset($array['dev_name']) && $array['dev_name'] !== '') {
            $imei = explode(',', preg_replace('/[^0-9a-z,]/', '', strtolower($array['serial'])));
            $response = $this->api_response($imei);
            $response = json_decode($response, true);
            $makeModel = [];
            if ($response['result'] != 'failed') {
                $makeModel = json_decode($this->getMakeModel($imei), true);
            }
            $data = $response;
            $data['makes'] = $makeModel && $makeModel['makes'] ? $makeModel['makes'] : [];
            return $data;
        }
    }

    public function api_response($serials)
    {
        $serials[0] = substr($serials[0], 0, 15);

        // Validate serials
        if (empty($serials) || !is_array($serials)) {
            return array('error' => 'Invalid serial number(s)');
        }

        $store_id = '2';
        $api_url = 'https://gapi.checkmend.com/duediligence/' . $store_id . '/' . $serials[0];
        $partner_id = '96';
        $secret_key = '';

        $request_url = rtrim($api_url, '/\\');
        $request = json_encode(array('storeid' => $store_id, 'category' => 0, 'serials'  => $serials, 'organisationid' => 1, 'fmipstatus' => true));

        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n" .
                    "Authorization: Basic " . base64_encode($partner_id . ':' . sha1($secret_key . $request)) . "\r\n",
                'content' => $request,
                'timeout' => 60
            )
        );

        $context  = stream_context_create($opts);
        $response = file_get_contents($request_url, false, $context);

        return $response;
    }

    public function getMakeModel($serials)
    {
        $serials[0] = substr($serials[0], 0, 15);

        // Validate serials
        if (empty($serials) || !is_array($serials)) {
            return array('error' => 'Invalid serial number(s)');
        }

        $store_id = '2';
        $api_url = 'https://gapi.checkmend.com/makemodelext/' . $store_id . '/' . $serials[0];
        $partner_id = '96';
        $secret_key = '';

        $request_url = rtrim($api_url, '/\\');
        $request = json_encode(array('storeid' => $store_id, 'category' => 0, 'serials'  => $serials, 'organisationid' => 1, 'fmipstatus' => true));

        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n" .
                    "Authorization: Basic " . base64_encode($partner_id . ':' . sha1($secret_key . $request)) . "\r\n",
                'content' => $request,
                'timeout' => 60
            )
        );

        $context  = stream_context_create($opts);
        $response = file_get_contents($request_url, false, $context);

        return $response;
    }
}
