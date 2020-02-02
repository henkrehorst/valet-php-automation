<?php


namespace App\Modules\Bintray\Endpoint;


use App\Modules\Bintray\Client\ClientInterface;
use App\Modules\Bintray\Client\Credentials;

class PublishPackageEndpoint extends Endpoint
{
    private $credentials;

    public function __construct(ClientInterface $client, Credentials $credentials)
    {
        $this->credentials = $credentials;
        parent::__construct($client, $this->setAuth());
    }

    private function setAuth(): string
    {
        return "{$this->credentials->getUsername()}:{$this->credentials->getApiToken()}";
    }

    public function setPackageInformation($package, $packageVersion)
    {
        // add empty body, no extra info in the required
        $this->setBody("{}");
        $this->setUrl($this->buildUrl($package, $packageVersion));
    }

    private function buildUrl($package, $packageVersion): string
    {
        return "{$this->credentials->getUrl()}/content/{$this->credentials->getUsername()}" .
            "/{$this->credentials->getPackageRepository()}/{$package}/{$packageVersion}/publish";
    }
}