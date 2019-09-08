<?php


namespace App\Modules\Travis\Client;

use App\Modules\Travis\Endpoint\Endpoint;

interface ClientInterface
{
    public function doRequest(Endpoint $endpoint);
}