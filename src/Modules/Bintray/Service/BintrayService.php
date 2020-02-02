<?php


namespace App\Modules\Bintray\Service;


use App\Modules\Bintray\Handler\BintrayHandler;

class BintrayService
{
    private $bintrayHandler;

    public function __construct(BintrayHandler $bintrayHandler)
    {
        $this->bintrayHandler = $bintrayHandler;
    }

    public function publishPackage($package, $packageVersion)
    {
        return $this->bintrayHandler->publishPackage($package, $packageVersion);
    }
}