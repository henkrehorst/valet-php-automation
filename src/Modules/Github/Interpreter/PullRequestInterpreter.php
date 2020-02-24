<?php


namespace App\Modules\Github\Interpreter;


class PullRequestInterpreter
{
    const URL_INDEX = "html_url";

    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getUrl()
    {
        return $this->content[self::URL_INDEX];
    }
}