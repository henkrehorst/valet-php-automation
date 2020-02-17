<?php


namespace App\Modules\AzureDevOps\Model;


class BuildConfig
{
    const VARIABLES_INDEX = "variables";
    const RESOURCES_INDEX = "resources";
    const REPOSITORY_INDEX = "repositories";
    const BRANCH_INDEX = "refName";
    const UPDATE_ID_VARIABLE_PREFIX = "-update-id";
    const VALUE_INDEX = "value";
    const SKIP_STAGES_INDEX = "stagesToSkip";


    private $branch;
    private $variables = [];
    private $updateIdVariables = [];

    public function __construct($branch)
    {
        $this->setBranch($branch);
    }

    /**
     * @param mixed $branch
     */
    public function setBranch($branch): void
    {
        $this->branch = "refs/heads/{$branch}";
    }

    /**
     * @return mixed
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param array $updateIdVariable
     */
    public function setUpdateIdVariable($updateId, $platformName)
    {
        $this->updateIdVariables[$platformName . self::UPDATE_ID_VARIABLE_PREFIX] = $updateId;
    }

    /**
     * @param array $variables
     */
    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        $variablesArray = [];
        //format variables for build request
        foreach ($this->variables as $name => $value) {
            $variablesArray[$name] = [
                self::VALUE_INDEX => $value
            ];
        }

        //add update id variables in variables
        foreach ($this->updateIdVariables as $name => $value) {
            $variablesArray[$name] = [
                self::VALUE_INDEX => $value
            ];
        }

        return $variablesArray;
    }

    /**
     * @return string
     */
    public function getJson(): string
    {
        return json_encode([
            self::SKIP_STAGES_INDEX => [],
            self::RESOURCES_INDEX => [
                self::REPOSITORY_INDEX => [
                    "self" => [
                        self::BRANCH_INDEX => $this->getBranch()
                    ]
                ]
            ],
            self::VARIABLES_INDEX => $this->getVariables()
        ]);
    }
}