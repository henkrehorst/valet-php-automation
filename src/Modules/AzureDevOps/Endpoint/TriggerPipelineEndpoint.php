<?php


namespace App\Modules\AzureDevOps\Endpoint;


use App\Modules\AzureDevOps\Client\ClientInterface;
use App\Modules\AzureDevOps\Client\Credentials;

class TriggerPipelineEndpoint extends Endpoint
{
    private $credentials;

    public function __construct(ClientInterface $client, Credentials $credentials)
    {
        $this->credentials = $credentials;
        parent::__construct($client, $this->setAuth(), $this->setApiVersion());
    }

    private function setAuth(): string
    {
        return "{$this->credentials->getUsername()}:{$this->credentials->getAccessToken()}";
    }

    private function setApiVersion(): string
    {
        return $this->credentials->getApiVersion();
    }

    public function setBuildConfig($buildConfig)
    {
        $this->setBody($buildConfig);
        $this->setUrl($this->buildUrl());
    }


    private function buildUrl(): string
    {
        return "{$this->credentials->getUrl()}/{$this->credentials->getOrganization()}/" .
            "{$this->credentials->getProject()}/_apis/pipelines/2/runs";
    }
}