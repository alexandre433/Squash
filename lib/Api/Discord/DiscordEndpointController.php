<?php

namespace Squash\Api\Discord;

use Squash\Contract\Api\DiscordEndpointInterface;

final class DiscordEndpointController implements DiscordEndpointInterface
{
    /**
     * Sends a message to a Discord webhook.
     *
     * @param string $message The message to send.
     * @param string $webhookUrl The URL of the Discord webhook.
     * @param array|null $additionalData Optional. Additional data to send with the message.
     *
     * @return void
     *
     * @throws \Exception If there is an error executing the cURL request.
     */
     
    public function sendWebhookMessage(string $message, string $webhookUrl, array $additionalData = null): void
    {
        /* Thank you to https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c for the original code */

        $json_data = json_encode([
            "content" => $message,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        echo $response;
        curl_close($ch);
    }
}
