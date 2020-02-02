<?php


namespace App\Modules\Bintray\Client;


use App\Modules\Bintray\Endpoint\Endpoint;

interface ClientInterface
{
    public function doRequest(Endpoint $endpoint);
}