<?php


namespace App\Modules\Travis\Model;


class Config
{
    const ADD_ON_INDEX = "addons";
    const IMAGE_INDEX = "osx_image";
    const JOB_INDEX = "jobs";
    const OS_INDEX = "os";
    const INCLUDE_INDEX = "include";
    const SCRIPT_INDEX = "script";

    private $os = [];
    private $osxImage = [];
    private $stages = [];

    /**
     * @return array
     */
    public function getOs(): array
    {
        return $this->os;
    }

    /**
     * @return array
     */
    public function getOsxImage(): array
    {
        return $this->osxImage;
    }

    private function getAddOns()
    {
        return [
            "homebrew" => [
                "update" => true
            ]
        ];
    }

    /**
     * @param string $osxImage
     */
    public function setOsxImage(string $osxImage): void
    {
        if (!in_array($osxImage, $this->osxImage)) {
            $this->osxImage[] = $osxImage;
        }
    }

    /**
     * @param string $os
     */
    public function setOs(string $os): void
    {
        if (!in_array($os, $this->os)) {
            $this->os[] = $os;
        }
    }

    public function setStage(string $name, string $image, array $variables)
    {
        $stage = new Stage($name, $variables, $image);

        return $this->stages[] = $stage;
    }

    /**
     * @param bool $disableTest
     * @return array
     */
    public function getStages()
    {
        $stages = [];

        foreach ($this->stages as $stage){
            $stages[] = $stage->toArray();
        }

        return $stages;
    }

    /**
     * Disable annoying test stage
     */
    private function disableTestStage()
    {
        return "true";
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            self::OS_INDEX => $this->getOs(),
            self::IMAGE_INDEX => $this->getOsxImage(),
            self::SCRIPT_INDEX => $this->disableTestStage(),
            self::ADD_ON_INDEX => $this->getAddOns(),
            self::JOB_INDEX => [
                self::INCLUDE_INDEX => $this->getStages()
            ]
        ];
    }
}