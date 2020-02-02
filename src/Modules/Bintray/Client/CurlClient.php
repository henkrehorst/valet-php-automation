<?php


namespace App\Modules\Bintray\Client;


use App\Modules\Bintray\Endpoint\Endpoint;
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

        //user auth
        curl_setopt($ch, CURLOPT_USERPWD, $endpoint->getAuth());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        if ($endpoint->isPost()) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $endpoint->getBody());
        }

        $response = curl_exec($ch);

        //TODO-HENK add logging
        curl_close($ch);

        return $response;
    }
}