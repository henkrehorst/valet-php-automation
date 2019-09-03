<?php


namespace App\Modules\PhpNet\Service;


use App\Modules\PhpNet\Handler\PhpNetHandler;

/**
 * Class PhpNetService
 * @package App\Modules\PhpNet\Service
 */
class PhpNetService
{
    private $phpNetHandler;

    public function __construct(PhpNetHandler $phpNetHandler)
    {
        $this->phpNetHandler = $phpNetHandler;
    }

    /**
     * @param string $minorVersion
     * @return string
     */
    public function getLatestReleaseVersion(string $minorVersion)
    {
        return $this->phpNetHandler->getVersionByNumber($minorVersion)->getLatestVersion();
    }

    /**
     * @param string $minorVersion
     * @return string
     */
    public function getLatestPackageHash(string $minorVersion)
    {
        return $this->phpNetHandler->getVersionByNumber($minorVersion)->getPackageHash()->getTarXZ();
    }

}