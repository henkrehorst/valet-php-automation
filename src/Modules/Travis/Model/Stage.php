<?php


namespace App\Modules\Travis\Model;


class Stage
{
    const OSX_IMAGE_INDEX = "osx_image";
    const SCRIPT_INDEX = "script";
    const ENV_INDEX = "env";
    const STAGE_INDEX = "stage";

    private $name = "";
    private $env = [];
    private $image = "";
    private $script = "bash scripts/travisbuild";

    public function __construct($name, $env, $image)
    {
        $this->setName($name);
        $this->setEnv($env);
        $this->setImage($image);
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $env
     */
    public function setEnv(array $env): void
    {
        $this->env = $env;
    }

    /**
     * @return array
     */
    public function getEnv(): array
    {
        return $this->env;
    }

    /**
     * @param string $script
     */
    public function setScript(string $script): void
    {
        $this->script = $script;
    }

    /**
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }

    public function toArray()
    {
        return[
            self::STAGE_INDEX => $this->getName(),
            self::OSX_IMAGE_INDEX => $this->getImage(),
            self::ENV_INDEX => $this->getEnv(),
            self::SCRIPT_INDEX => $this->getScript()
        ];
    }
}