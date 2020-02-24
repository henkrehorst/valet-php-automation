<?php


namespace App\Modules\Slack\Client;


class Credentials
{
    const INDEX_WEBHOOK_URL = "SLACK_WEBHOOK_URL";

    /**
     * @return string
     */
    public function getWebhookUrl()
    {
        return getenv(self::INDEX_WEBHOOK_URL);
    }
}