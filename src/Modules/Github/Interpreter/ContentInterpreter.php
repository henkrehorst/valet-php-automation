<?php


namespace App\Modules\Github\Interpreter;


class ContentInterpreter
{
    const CONTENT_INDEX = "content";
    const SHA_INDEX = "sha";

    private $content;
    private $sha;

    public function __construct($result)
    {
        $this->sha = $result[self::SHA_INDEX];
        $this->content = base64_decode($result[self::CONTENT_INDEX]);
    }

    public function getPhpVersionFromFile()
    {
        preg_match('/(?<=php.net\/get\/php-)(.*)(?=.tar.xz\/from\/this\/mirror)/', $this->content, $m);
        return $m[0];
    }

    /**
     * @return bool|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getSha()
    {
        return $this->sha;
    }
}