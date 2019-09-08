<?php


namespace App\Modules\Travis\Endpoint;


use App\Modules\Travis\Client\ClientInterface;
use App\Modules\Travis\Client\Credentials;

class TriggerBuildEndpoint extends Endpoint
{
    private $credentials;
    private $ProjectId;

    public function __construct(ClientInterface $client, Credentials $credentials)
    {
        $this->credentials = $credentials;

        parent::__construct($client, $this->setUrl(), $this->setAuth());
    }

    /**
     * @param mixed $ProjectId
     */
    public function setProjectId($ProjectId): void
    {
        $this->ProjectId = $ProjectId;

        //quick fix update url
        $this->url = $this->setUrl();
    }

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->ProjectId;
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
            $this->getProjectId(),
            'requests'
        ];

        return implode("/", $path);
    }
}