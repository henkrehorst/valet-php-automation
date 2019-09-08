<?php


namespace App\Modules\Travis\Handler;

use App\Modules\Travis\Endpoint\GetProjectEndpoint;
use App\Modules\Travis\Endpoint\TriggerBuildEndpoint;
use App\Modules\Travis\Interpreter\ProjectInterpreter;
use App\Modules\Travis\Model\BuildRequest;

class TravisHandler
{
    private $getProjectEndpoint;
    private $triggerBuildEndpoint;

    public function __construct(GetProjectEndpoint $getProjectEndpoint, TriggerBuildEndpoint $triggerBuildEndpoint)
    {
        $this->getProjectEndpoint = $getProjectEndpoint;
        $this->triggerBuildEndpoint = $triggerBuildEndpoint;
    }

    /**
     * @return ProjectInterpreter
     */
    public function getProject()
    {
        return new ProjectInterpreter(json_decode($this->getProjectEndpoint->doRequest(), true));
    }

    /**
     * @param $projectId
     * @param BuildRequest $buildRequest
     * @return mixed
     */
    public function runBuild($projectId, BuildRequest $buildRequest)
    {
        $this->triggerBuildEndpoint->setProjectId($projectId);
        $this->triggerBuildEndpoint->setBody(json_encode($buildRequest->getBuildRequest()));

        return $this->triggerBuildEndpoint->doRequest();
    }
}