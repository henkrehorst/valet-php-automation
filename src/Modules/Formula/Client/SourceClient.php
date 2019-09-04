<?php


namespace App\Modules\Formula\Client;

/**
 * Update source of formula
 *
 * Class SourceClient
 * @package App\Modules\Formula\Client
 */
class SourceClient
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function updatePhpReleaseVersion($version)
    {
        $this->content = preg_replace('/(?<=php.net\/get\/php-)(.*)(?=.tar.xz\/from\/this\/mirror)/', $version, $this->content);

        return $this;
    }

    public function updatePhpPackageHash($hash)
    {
        $this->content = preg_replace('/(?<=sha256 ")(.*)(?=")/', $hash, $this->content,1);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}