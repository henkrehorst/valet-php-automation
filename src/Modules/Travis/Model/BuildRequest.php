<?php


namespace App\Modules\Travis\Model;


class BuildRequest
{
    const REQUEST_INDEX = "request";
    const CONFIG_INDEX = "config";
    const MESSAGE_INDEX = "message";
    const BRANCH_INDEX = "branch";

    private $branch = "master";
    private $message = "";
    private $config;

    public function __construct($branch, $message)
    {
        $this->setBranch($branch);
        $this->setMessage($message);
        $this->config = new Config();
    }


    /**
     * @param string $branch
     */
    public function setBranch(string $branch): void
    {
        $this->branch = $branch;
    }

    /**
     * @return string
     */
    public function getBranch(): string
    {
        return $this->branch;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getBuildRequest()
    {
        return [
            self::REQUEST_INDEX => [
                self::BRANCH_INDEX => $this->getBranch(),
                self::MESSAGE_INDEX => $this->getMessage(),
                self::CONFIG_INDEX => $this->getConfig()->getArray()
            ]
        ];
    }


}
