<?php


namespace App\Modules\PhpNet\Handler;


use App\Modules\PhpNet\Endpoint\PhpNetEndpoint;

/**
 * Class PhpNetHandler
 * @package App\Modules\PhpNet\Handler
 */
class PhpNetHandler
{
    private $phpNetEndpoint;

    /**
     * PhpNetHandler constructor.
     * @param PhpNetEndpoint $phpNetEndpoint
     */
    public function __construct(PhpNetEndpoint $phpNetEndpoint)
    {
        $this->phpNetEndpoint = $phpNetEndpoint;
    }

    /**
     * @param $version
     * @return mixed
     */
    public function getVersionByNumber($version)
    {
        $this->phpNetEndpoint->setQueryParams([
            "json" => "json",
            "version" => $version
        ]);

        return $this->phpNetEndpoint->doRequest();
    }

    /**
     * @return mixed
     */
    public function getVersionInformation()
    {
        $this->phpNetEndpoint->setQueryParams([
            "json" => "json"
        ]);

        return $this->phpNetEndpoint->doRequest();
    }

}