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
        $lineBot = $this->lineBot;
        try {
            $this->baseEvent = $lineBot->parseEventRequest($body, $signature);
        } catch (Exception $e) {
            $log = new LogModel;
            $log->putLog("ReplyEvent.txt", $e);
        }
    }
    /**
     * initTextMessageEvent
     */
    private function initTextMessageEvent()
    {
        $this->textMessageEvent = new LINE\LINEBot\Event\MessageEvent\TextMessage($this->baseEvent);
    }
    /**
     * @return string|null
     */
    public function getUserId()
    {
        return $this->textMessageEvent->getUserId();
    }
    /**
     * @return string|null
     */
    public function getReplyToken()
    {
        return $this->textMessageEvent->getReplyToken();
    }
    /**
     * for test
     */
    public function test()
    {
        $log = new LogModel;
        $log->putLog("test.txt", "UserId:{$this->getUserId()} || ReplyToken:{$this->getReplyToken()} || Text:{$this->textMessageEvent->getText()} ");
    }
}
