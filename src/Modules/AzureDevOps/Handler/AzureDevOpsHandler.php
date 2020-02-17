<?php


namespace App\Modules\AzureDevOps\Handler;


use App\Modules\AzureDevOps\Endpoint\TriggerPipelineEndpoint;

class AzureDevOpsHandler
{
    private $triggerPipelineEndpoint;

    public function __construct(TriggerPipelineEndpoint $triggerPipelineEndpoint)
    {
        $this->triggerPipelineEndpoint = $triggerPipelineEndpoint;
    }

    public function triggerPipeline($buildConfig)
    {
        $this->triggerPipelineEndpoint->setBuildConfig($buildConfig);

        return $this->triggerPipelineEndpoint->doRequest();
    }
}