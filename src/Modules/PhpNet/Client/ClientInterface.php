<?php

namespace App\Modules\PhpNet\Client;


use App\Modules\PhpNet\Endpoint\Endpoint;

interface ClientInterface
{
    public function doRequest(Endpoint $endpoint);
}