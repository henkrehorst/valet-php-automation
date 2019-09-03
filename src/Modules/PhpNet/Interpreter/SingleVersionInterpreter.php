<?php


namespace App\Modules\PhpNet\Interpreter;


class SingleVersionInterpreter
{
    const PACKAGE_INDEX = "source";
    const VERSION_INDEX = "version";

    private $result = [];

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getLatestVersion()
    {
        return $this->result[self::VERSION_INDEX];
    }

    /**
     * @return PackageHashInterpreter
     */
    public function getPackageHash()
    {
        return new PackageHashInterpreter($this->result[self::PACKAGE_INDEX]);
    }
}