<?php


namespace App\Modules\Travis\Endpoint;


use App\Modules\Travis\Client\ClientInterface;
use App\Modules\Travis\Client\Credentials;

class GetProjectEndpoint extends Endpoint
{

    private $credentials;

    public function __construct(ClientInterface $client, Credentials $credentials)
    {
        $this->credentials = $credentials;

        parent::__construct($client, $this->setUrl(), $this->setAuth());
    }

    private function setUrl()
    {
        return $this->credentials->getUrl() . $this->buildPath();
    }

    private function setAuth()
    {
        return "token " . $this->credentials->getToken();
    }

    private function buildPath()
    {
        $path = [
            'repo',
            urlencode(implode('/', [$this->credentials->getUser(), $this->credentials->getProject()])),
        ];

        return implode("/", $path);
    }

}