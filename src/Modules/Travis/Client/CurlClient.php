<?php


namespace App\Modules\Travis\Client;


use App\Modules\Travis\Endpoint\Endpoint;

class CurlClient implements ClientInterface
{
    /**
     * @param Endpoint $endpoint
     * @return bool|string
     */
    public function doRequest(Endpoint $endpoint)
    {
        $headers = [
            'Content-Type:application/json',
            'Accept:application/json',
            'Travis-API-Version:3',
            'Authorization:' . $endpoint->getAuth()
        ];

        $ch = curl_init($endpoint->getUrl());

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($endpoint->isPost()) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $endpoint->getBody());
        }

        $this->statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response = curl_exec($ch);

        //TODO-HENK add logging

        curl_close($ch);


        return $response;
    }
}