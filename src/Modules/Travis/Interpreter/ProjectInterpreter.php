<?php


namespace App\Modules\Travis\Interpreter;


class ProjectInterpreter
{
    const PROJECT_ID_INDEX = "id";

    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function getProjectId()
    {
        return $this->result[self::PROJECT_ID_INDEX];
    }
}