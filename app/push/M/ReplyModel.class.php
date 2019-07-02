<?php
class ReplyModel extends LineBotModel
{
    /**
     * @var LINE\LINEBot\Event\BaseEvent[] array $baseEvent
     */
    private $baseEvent;
    /**
     * @var LINE\LINEBot\Event\MessageEvent\TextMessage $textMessageEvent
     */
    private $textMessageEvent;
    /**
     * @var LogModel $logM
     */
    private $logM;
    public function __construct()
    {
        parent::__construct();
        $this->initBaseEvent();
        $this->initTextMessageEvent();
    }
    /**
     * initbaseEvent
     */
    private function initBaseEvent()
    {
        $httpHeader = new LINE\LINEBot\Constant\HTTPHeader;
        $signature = $_SERVER['HTTP_' . $httpHeader::LINE_SIGNATURE];
        $body = file_get_contents('php://input');
        //for test
        if (0) {
            $body = '{"events":[{"type":"message","replyToken":"49261eab816e4d7c8a4645505de75100","source":{"userId":"U9a18b6f2e16d64b41f6783e454e3b425","type":"user"},"timestamp":1561988232348,"message":{"type":"text","id":"10138128552568","text":"測試"}}],"destination":"U5ea8112fb95806b31b7b189136953810"}';
            $signature = '4qpcTeH5WUE5c6YBgPupixbwGUwf/BH5iNjRXZHCipc=';
        }
        try {
            $this->logM = new LogModel;
            $this->baseEvent = $this->lineBot->parseEventRequest($body, $signature);
        } catch (Exception $e) {
            $this->logM->putLog("ReplyEvent.txt", $e);
        }
    }
    /**
     * initTextMessageEvent
     */
    private function initTextMessageEvent()
    {
        foreach ($this->baseEvent as $event) {
            $tempEvent = [];
            if ($event instanceof LINE\LINEBot\Event\MessageEvent\TextMessage) {
                $tempEvent['userId'] = $event->getUserId();
                $tempEvent['replyToken'] = $event->getReplyToken();
                $tempEvent['timestamp'] = $event->getTimestamp();
                $tempEvent['text'] = $event->getText();
                $jsonEvent = json_encode($tempEvent, JSON_UNESCAPED_UNICODE);
                $this->textMessageEvent[] = $tempEvent;
                $this->logM->putLog("textEvent.txt", "$jsonEvent");
            }
        }
    }
    /**
     * @return string|null
     */
    public function getUserId()
    {
        return $this->baseEvent->getUserId();
    }
    /**
     * @return string|null
     */
    public function getReplyToken()
    {
        return $this->baseEvent->getReplyToken();
    }
    /**
     * @return string|null
     */
    public function getText()
    {
        return $this->baseEvent->getText();
    }
    /**
     * get textMessageEvent
     */
    public function getTextMessageEvent()
    {
        return $this->textMessageEvent;
    }
    /**
     * reply text
     */
    public function reply($replyToken, $text, $extraTexts = null)
    {
        $response = $this->lineBot->replyText($replyToken, $text, $extraTexts);
        if ($response->isSucceeded()) {
            $this->logM->putLog('ReplyMessage.txt', "{$text} {\"ReplyToken\":\"{$replyToken}\"}");
        } else {
            $this->logM->putLog('ReplyMessage.txt', "[傳送失敗:{$response->getHTTPStatus()}] {$text} {\"ReplyToken\":\"{$replyToken}\"}");
        }
    }
    /**
     * @param string $userText
     * @param string $replyText
     */
    public function replyText($userText, $replyText)
    {
        $textMessageEvent = $this->getTextMessageEvent();
        foreach ($textMessageEvent as $text) {
            if ($text['text'] == $userText) {
                $this->reply($text['replyToken'], $replyText);
            }
        }
    }
    /**
     * for test
     */
    public function test()
    {
        foreach ($this->textMessageEvent as $event) {
            echo "userId:{$event['userId']} text:{$event['text']} replyToken:{$event['replyToken']}";
        }
    }
}
