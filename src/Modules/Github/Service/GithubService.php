<?php


namespace App\Modules\Github\Service;


use App\Modules\Github\Handler\GithubHandler;

class GithubService
{
    private $githubHandler;

    public function __construct(GithubHandler $githubHandler)
    {
        $this->githubHandler = $githubHandler;
    }

    public function getFilesFromFormulaFolder()
    {
        return $this->githubHandler->getFilesInFolder();
    }

    public function getPhpVersionFromFile($filename)
    {
        return $this->githubHandler->getFileContent($filename)->getPhpVersionFromFile();
    }

}