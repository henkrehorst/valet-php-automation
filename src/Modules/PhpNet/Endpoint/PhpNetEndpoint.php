<?php

namespace App\Modules\PhpNet\Endpoint;

use App\Modules\PhpNet\Client\ClientInterface;
use App\Modules\PhpNet\Client\Credentials;

/**
 * Class PhpNetEndpoint
 * @package App\Modules\PhpNet\Endpoint
 */
class PhpNetEndpoint extends Endpoint
{
    private $url;
    private $credentials;

    /**
     * PhpNetEndpoint constructor.
     * @param ClientInterface $client
     * @param Credentials $credentials
     */
    public function __construct(ClientInterface $client, Credentials $credentials)
    {
        $this->credentials = $credentials;
        $this->setUrl();

        parent::__construct($client, $this->url);
    }

    /**
     * @return array|false|string
     */
    private function setUrl()
    {
        return $this->url = $this->credentials->getUrl();
    }

    /**
     * @param mixed $queryParams
     * @return mixed
     */
    public function setQueryParams($queryParams): void
    {
        parent::setQueryParams($queryParams);
    }
}