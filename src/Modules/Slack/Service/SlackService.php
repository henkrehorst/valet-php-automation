<?php


namespace App\Modules\Slack\Service;


use App\Modules\Slack\Client\SlackClient;

class SlackService
{
    private $slackClient;

    /**
     * SlackService constructor.
     * @param SlackClient $slackClient
     */
    public function __construct(SlackClient $slackClient)
    {
        $this->slackClient = $slackClient;
    }

    /**
     * @param $message
     * @param null $channel
     * @return mixed
     */
    public function sendMessage($message, $channel = null)
    {
        return $this->slackClient->getClient($channel)->send($message);
    }
}