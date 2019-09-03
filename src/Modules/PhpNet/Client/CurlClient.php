<?php


namespace App\Modules\PhpNet\Client;


use App\Modules\PhpNet\Endpoint\Endpoint;
use Psr\Log\LoggerInterface;

/**
 * Class CurlClient
 * @package App\Modules\PhpNet\Client
 */
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

        curl_setopt($ch,CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        //TODO-HENK add logging

        curl_close($ch);

        return $response;
    }
}