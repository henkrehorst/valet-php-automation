<?php


namespace App\Modules\AzureDevOps\Endpoint;


use App\Modules\AzureDevOps\Client\ClientInterface;

/**
 * Class Endpoint
 * @package App\Modules\Bintray\Endpoint
 */
class Endpoint
{
    private $client;
    private $url;
    private $isPost = false;
    private $body;
    private $auth;
    private $apiVersion;

    /**
     * Endpoint constructor.
     * @param ClientInterface $client
     * @param $url
     */
    public function __construct(ClientInterface $client, $auth, $apiVersion)
    {
        $this->auth = $auth;
        $this->client = $client;
        $this->apiVersion = $apiVersion;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function doRequest()
    {
        return $this->client->doRequest($this);
    }

    public function setBody($body)
    {
        $this->isPost = True;
        $this->body = $body;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->isPost;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }


}