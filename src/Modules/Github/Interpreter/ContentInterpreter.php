<?php


namespace App\Modules\Github\Interpreter;


class ContentInterpreter
{
    const CONTENT_INDEX = "content";

    private $content;

    public function __construct($result)
    {
        $this->content = base64_decode($result[self::CONTENT_INDEX]);
    }

    public function getPhpVersionFromFile()
    {
        preg_match('/(?<=php.net\/get\/php-)(.*)(?=.tar.xz\/from\/this\/mirror)/', $this->content, $m);
        return $m[0];
    }
}