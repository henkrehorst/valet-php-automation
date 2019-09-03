<?php


namespace App\Modules\PhpNet\Handler;


use App\Modules\PhpNet\Endpoint\PhpNetEndpoint;
use App\Modules\PhpNet\Interpreter\SingleVersionInterpreter;

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
     * @return SingleVersionInterpreter
     */
    public function getVersionByNumber($version)
    {
        $this->phpNetEndpoint->setQueryParams([
            "json" => "json",
            "version" => $version
        ]);

        return new SingleVersionInterpreter((array)json_decode($this->phpNetEndpoint->doRequest(), true));
    }
}