<?php


namespace App\Modules\PhpNet\Endpoint;


use App\Modules\PhpNet\Client\ClientInterface;

/**
 * Class Endpoint
 * @package App\Modules\PhpNet\Endpoint
 */
class Endpoint
{
    private $client;
    private $url;
    private $queryParams;

    /**
     * Endpoint constructor.
     * @param ClientInterface $client
     * @param $url
     */
    public function __construct(ClientInterface $client, $url)
    {
        $this->client = $client;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $url = $this->url;
        $url .= '?' . http_build_query($this->queryParams);
        return $url;
    }

    /**
     * @return mixed
     */
    public function doRequest()
    {
        return $this->client->doRequest($this);
    }

    /**
     * @param mixed $queryParams
     */
    public function setQueryParams($queryParams)
    {
        $this->queryParams = $queryParams;
    }

}