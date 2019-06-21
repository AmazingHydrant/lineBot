<?php
class PushModel
{
    /**
     * push message and add log
     * @param array $userList to
     * @param LINE\LINEBot\MessageBuilder $userList $messageBuilder
     */
    public function pushMessage($userList, $messageBuilder)
    {
        $channelToken = json_decode(file_get_contents(PLATFORM_DIR . 'token'), true)['channelToken'];
        $httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient($channelToken);
        $channelSecret = json_decode(file_get_contents(PLATFORM_DIR . 'token'), true)['channelSecret'];
        $lineBot = new LINE\LINEBot($httpClient, array('channelSecret' => $channelSecret));
        $log_M = new LogModel;
        foreach ($userList as $to) {
            $response = $lineBot->pushMessage($to, $messageBuilder);
            $message = $messageBuilder->buildMessage();
            $jsonMessage = json_encode($message, JSON_UNESCAPED_UNICODE);
            if ($response->isSucceeded()) {
                $log_M->putLog('pushMessage.txt', "{$jsonMessage} to {$to}");
            } else {
                $log_M->putLog('pushMessage.txt', "[傳送失敗:{$response->getHTTPStatus()}] {$jsonMessage} to {$to}");
            }
        }
    }
}
