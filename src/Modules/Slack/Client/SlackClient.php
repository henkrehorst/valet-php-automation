<?php


namespace App\Modules\Slack\Client;


use Maknz\Slack\Client;

class SlackClient
{
    private $credentials;

    /**
     * SlackClient constructor.
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param null $channel
     * @return Client
     */
    public function getClient($channel = null)
    {
        // create empty settings array
        $settings = [];

        if ($channel != null) {
            $settings['channel'] = $channel;
        }

        return new Client($this->credentials->getWebhookUrl(), $settings);
    }
}