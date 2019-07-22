<?php
class ReplyModel extends LineBotModel
{
    /**
     * @var LogModel $logM
     */
    private $logM;
    /**
     * @var LINE\LINEBot\Event\BaseEvent[] array $baseEvent
     */
    private $baseEvent;
    /**
     * @var string $body Request body.
     */
    private $body;

    static public $test = false;

    public function __construct()
    {
        parent::__construct();
        $this->initLogModel();
        $this->initBaseEvent();
    }
    /**
     * initLogModel
     */
    private function initLogModel()
    {
        $this->logM = new LogModel;
    }
    /**
     * initbaseEvent
     */
    private function initBaseEvent()
    {
        $httpHeader = new LINE\LINEBot\Constant\HTTPHeader;
        $signature = $_SERVER['HTTP_' . $httpHeader::LINE_SIGNATURE];
        $this->body = file_get_contents('php://input');
        //for test
        if (self::$test) {
            $fp = file(LOG_ROOT . 'Event.txt');
            $this->body = explode(' ', $fp[count($fp) - 2])[2];
            $this->body = str_replace(PHP_EOL, '', $this->body);
            $signature = explode(' ', $fp[count($fp) - 1])[2];
            $signature = str_replace(PHP_EOL, '', $signature);
        }
        //for test end
        try {
            $this->baseEvent = $this->parseEventRequest($this->body, $signature);
            M('User')->findNewUser($this->getUserId());
            $this->logM->putLog("Event.txt", $this->body);
            $this->logM->putLog("Event.txt", $signature);
        } catch (Exception $e) {
            $this->logM->putLog("exceptionEvent.txt", $e);
        }
    }
    /**
     * @return string|null
     */
    public function getUserId()
    {
        return $this->baseEvent[0]->getUserId();
    }
    /**
     * @return string|null
     */
    public function getReplyToken()
    {
        return $this->baseEvent[0]->getReplyToken();
    }
    /**
     * @return string|null
     */
    public function getText()
    {
        return $this->baseEvent[0]->getText();
    }
    /**
     * reply text
     */
    public function reply($text)
    {
        $response = $this->replyText($this->baseEvent[0]->getReplyToken(), $text);
        if ($response->isSucceeded()) {
            $this->logM->putLog('ReplyMessage.txt', "{\"text\":\"{$text}\", \"userId\":\"{$this->baseEvent[0]->getUserId()}\", \"replyToken\":\"{$this->baseEvent[0]->getReplyToken()}\"}");
        } else {
            $this->logM->putLog('ReplyMessage.txt', "[傳送失敗:{$response->getHTTPStatus()}] {$response->getRawBody()}");
        }
    }
    /**
     * for test
     */
    public function test()
    {
        if (count($this->baseEvent) == 1) {
            $this->replyText($this->baseEvent[0]->getReplyToken(), count($this->baseEvent));
        } else {
            foreach ($this->baseEvent as $event) {
                if ($event->getText()) {
                    $this->replyText($event->getReplyToken(), count($this->baseEvent));
                }
            }
        }
    }
}
