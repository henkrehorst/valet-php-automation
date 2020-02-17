<?php


namespace App\Modules\AzureDevOps\Client;


use App\Modules\AzureDevOps\Endpoint\Endpoint;
use Psr\Log\LoggerInterface;

class CurlClient implements ClientInterface
{
    private $logger;

    /**
     * CurlClient constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Endpoint $endpoint
     * @return bool|string
     */
    public function doRequest(Endpoint $endpoint)
    {
        $ch = curl_init($endpoint->getUrl());

        //follow redirects
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: application/json;api-version={$endpoint->getApiVersion()}"
        ]);

        //user auth
        curl_setopt($ch, CURLOPT_USERPWD, $endpoint->getAuth());

        if ($endpoint->isPost()) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $endpoint->getBody());
        }

        $response = curl_exec($ch);

        //TODO-HENK add logging
        curl_close($ch);

        return $response;
    }
}