<?php


namespace App\Modules\PhpNet\Interpreter;


class PackageHashInterpreter
{
    const TAR_GZ_INDEX = 1;
    const TAR_XZ_INDEX = 2;
    const B2Z_INDEX = 0;
    const HASH256_INDEX = "sha256";

    private $result;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getBz2()
    {
        return $this->result[self::B2Z_INDEX][self::HASH256_INDEX];
    }

    /**
     * @return string
     */
    public function getTarXZ()
    {
        return $this->result[self::TAR_XZ_INDEX][self::HASH256_INDEX];
    }

    /**
     * @return string
     */
    public function getTarGZ()
    {
        return $this->result[self::TAR_GZ_INDEX][self::HASH256_INDEX];
    }
}