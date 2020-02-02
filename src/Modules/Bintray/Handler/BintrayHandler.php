<?php


namespace App\Modules\Bintray\Handler;


use App\Modules\Bintray\Endpoint\PublishPackageEndpoint;

class BintrayHandler
{
    private $publishPackageEndpoint;

    public function __construct(PublishPackageEndpoint $publishPackageEndpoint)
    {
        $this->publishPackageEndpoint = $publishPackageEndpoint;
    }

    public function publishPackage($package, $packageVersion)
    {
        $this->publishPackageEndpoint->setPackageInformation($package, $packageVersion);

        return $this->publishPackageEndpoint->doRequest();
    }
}