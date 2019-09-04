<?php


namespace App\Modules\Formula\Service;


use App\Modules\Formula\Client\SourceClient;

/**
 * Edit formula content
 * Class FormulaService
 * @package App\Modules\Formula\Service
 */
class FormulaService
{
    public function updatePhpSource($content, $releaseVersion, $packageHash)
    {
        $sourceClient = new SourceClient($content);

        //update release version
        $sourceClient->updatePhpReleaseVersion($releaseVersion);

        //update sha256 package hash
        $sourceClient->updatePhpPackageHash($packageHash);

        return $sourceClient->getContent();
    }


}