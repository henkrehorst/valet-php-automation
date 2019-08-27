<?php


namespace App\Modules\Github\Client;

use Github\Client;

/**
 * Class GithubClient
 * @package App\Modules\Github\Client
 */
class GithubClient
{
    private $githubClient;
    private $credentials;

    public function __construct(Client $githubClient, Credentials $credentials)
    {
        $this->credentials = $credentials;
        $this->githubClient = $githubClient;

        $this->githubClient->authenticate($this->credentials->getSecret(), $this->credentials->getUsername(), $this->credentials->getAuthMethod());
    }

    public function client()
    {
        return $this->githubClient;
    }

    public function committer()
    {
        return $this->credentials->getCommitter();
    }
}