<?php


namespace App\Modules\Formula\Service;


use App\Entity\Update;
use App\Modules\Bintray\Client\Credentials;
use App\Modules\Formula\Client\SourceClient;

/**
 * Edit formula content
 * Class FormulaService
 * @package App\Modules\Formula\Service
 */
class FormulaService
{
    private $bintrayCredentials;

    public function __construct(Credentials $bintrayCredentials)
    {
        $this->bintrayCredentials = $bintrayCredentials;
    }

    public function updatePhpSource($content, $releaseVersion, $packageHash)
    {
        $sourceClient = new SourceClient($content);

        //update release version
        $sourceClient->updatePhpReleaseVersion($releaseVersion);

        //update sha256 package hash
        $sourceClient->updatePhpPackageHash($packageHash);

        return $sourceClient->getContent();
    }

    public function updateRevisionVersion($content, Update $update)
    {
        $sourceClient = new SourceClient($content);

        //update the revision version
        $sourceClient->updateRevision($update);

        return $sourceClient->getContent();
    }

    public function updateBottleHashes($content, Update $update)
    {
        $sourceClient = new SourceClient($content);
        $sourceClient->updateBottleHashes($update, $this->bintrayCredentials->getPackageUrl());
        return $sourceClient->getContent();
    }
}