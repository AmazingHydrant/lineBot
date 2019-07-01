<?php
class PushModel extends LineBotModel
{
    /**
     * push message and add log
     * @param array $userList to
     * @param LINE\LINEBot\MessageBuilder $userList $messageBuilder
     */
    public function pushMessage($userList, $messageBuilder)
    {
        $lineBot = $this->lineBot;
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
