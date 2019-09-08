<?php


namespace App\Modules\Travis\Endpoint;

use App\Modules\Travis\Client\ClientInterface;

class Endpoint
{
    private $client;
    protected $url;
    private $auth;
    private $queryParams;
    private $body;
    private $isPost = false;

    public function __construct(ClientInterface $client, $url, $auth)
    {
        $this->client = $client;
        $this->url = $url;
        $this->auth = $auth;
    }

    public function getUrl()
    {
        $url = $this->url;

        if (!empty($this->queryParams)) {
            $url .= '?' . http_build_query($this->queryParams);
        }

        return $url;
    }

    public function doRequest()
    {
        return $this->client->doRequest($this);
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->isPost = true;
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->isPost;
    }

    /**
     * @param mixed $queryParams
     */
    public function setQueryParams($queryParams)
    {
        $this->queryParams = $queryParams;
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }
}