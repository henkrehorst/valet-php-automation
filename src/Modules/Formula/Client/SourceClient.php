<?php


namespace App\Modules\Formula\Client;

use App\Entity\Update;

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
        $this->content = preg_replace('/(?<=php.net\/distributions\/php-)(.*)(?=.tar.xz)/', $version, $this->content);

        return $this;
    }

    public function updatePhpPackageHash($hash)
    {
        $this->content = preg_replace('/(?<=sha256 ")(.*)(?=")/', $hash, $this->content, 1);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    public function updateRevision(Update $update)
    {
        $revisionBlock = "  sha256 \"{$update->getPackageHash()}\"\n";
        if ($update->getRevisionVersion() !== 0) {
            $revisionBlock .= "  revision {$update->getRevisionVersion()}\n";
        }
        $revisionBlock .= "\n";
        $revisionBlock .= "  bottle";

        // replace old revision block
        $this->content = preg_replace('/ {2}sha256((\n?.*?)*){2}bottle/', $revisionBlock, $this->content, 1);

        return $this->content;
    }

    public function updateBottleHashes(Update $update, $bintrayUrl)
    {
        // create new bottle do block
        $bottleBlock = "  bottle do\n";
        $bottleBlock .= "    root_url \"{$bintrayUrl}\"\n";
        foreach ($update->getPlatformUpdates() as $platformUpdate) {
            $bottleBlock .= "    sha256 \"{$platformUpdate->getBottleHash()}\" => :{$platformUpdate->getPlatform()->getName()}\n";
        }
        $bottleBlock .= "  end";

        // replace old bottle block
        $this->content = preg_replace('/ {2}bottle((\n?.*?)*)end/', $bottleBlock, $this->content, 1);

        return $this->content;
    }
}