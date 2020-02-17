<?php


namespace App\Modules\AzureDevOps\Client;


use App\Modules\AzureDevOps\Endpoint\Endpoint;

interface ClientInterface
{
    public function doRequest(Endpoint $endpoint);
}