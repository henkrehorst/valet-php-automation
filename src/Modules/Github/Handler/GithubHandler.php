<?php


namespace App\Modules\Github\Handler;


use App\Client\GlobalCredentials;
use App\Modules\Github\Interpreter\ContentInterpreter;
use App\Modules\Github\Client\GithubClient;

class GithubHandler
{
    const PACKAGES_FOLDER = "Formula";
    const DEFAULT_BRANCH = "develop";


    private $gitHub;
    private $globalCredentials;

    public function __construct(GithubClient $githubClient, GlobalCredentials $globalCredentials)
    {
        $this->gitHub = $githubClient;
        $this->globalCredentials = $globalCredentials;
    }

    public function getFileContent($filename, $branch = "")
    {
        if(empty($branch)){
            $branch = $this->globalCredentials->getBranch();
        }

        return new ContentInterpreter($this->gitHub->client()->api('repo')->contents()
            ->show($this->globalCredentials->getUsername(),
                $this->globalCredentials->getRepo(),
                self::PACKAGES_FOLDER . '/' . $filename,
                $branch));

    }

    public function getOrCreateBranchRef($branch)
    {
        $branchExist = false;
        $branchRef = "refs/heads/" . $branch;
        $references = $this->gitHub->client()->api('gitData')->references()->branches($this->globalCredentials->getUsername(), $this->globalCredentials->getRepo());

        foreach ($references as $ref) {
            if ($ref["ref"] == $branchRef) {
                $branchExist = true;
            }
        }

        if ($branchExist) {
            return $branch;
        } else {

            $referenceMaster = $this->gitHub->client()->api('gitData')->references()->show($this->globalCredentials->getUsername(), $this->globalCredentials->getRepo(), 'heads/' . $this->globalCredentials->getBranch());
            $referenceData = ['ref' => $branchRef, 'sha' => $referenceMaster['object']['sha']];

            $this->gitHub->client()->api('gitData')->references()->create($this->globalCredentials->getUsername(), $this->globalCredentials->getRepo(), $referenceData);

            return $branch;
        }
    }

    public function getFilesInFolder($folder = self::PACKAGES_FOLDER, $branch = "")
    {
        if(empty($branch)){
            $branch = $this->globalCredentials->getBranch();
        }

        return $this->gitHub->client()->api('repo')->contents()
            ->show($this->globalCredentials->getUsername(),
                $this->globalCredentials->getRepo(),
                $folder,
                $branch);
    }

    public function updateFileOnGithub($filename, $content, $message, $branch, $sha = '')
    {
        $committer = $this->gitHub->committer();

        if (empty($sha)) {
            $sha = $this->getFileContent($filename, $branch)->getSha();
        }

        return $this->gitHub->client()->api('repo')->contents()
            ->update($this->globalCredentials->getUsername(),
                $this->globalCredentials->getRepo(),
                self::PACKAGES_FOLDER . '/' . $filename,
                $content,
                $message,
                $sha,
                $branch,
                $committer);
    }
}