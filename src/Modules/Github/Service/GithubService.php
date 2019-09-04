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

    public function getFormulaContent($minorVersion, $branch)
    {
        return $this->githubHandler->getFileContent("valet-php@{$minorVersion}.rb", $branch)->getContent();
    }

    public function updateFormulaFile($minorVersion, $content, $message, $branch)
    {
        return $this->githubHandler->updateFileOnGithub("valet-php@{$minorVersion}.rb", $content, $message, $branch);
    }


    public function createNewBranch($branch)
    {
        return $this->githubHandler->getOrCreateBranchRef($branch);
    }

}