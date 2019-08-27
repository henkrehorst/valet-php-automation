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

    public function getPhpVersionInfo(array $phpVersions)
    {

    }

    public function getSinglePhpVersionInfo($version)
    {

    }

    public function getLatestPhpVersion()
    {

    }
}