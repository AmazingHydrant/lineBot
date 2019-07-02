<?php
class LineBotModel
{
    /**
     * @var LINE\LINEBot $lineBot
     */
    protected $lineBot;
    public function __construct()
    {
        $this->initLineBot();
    }
    /**
     * init LineBoot
     */
    private function initLineBot()
    {
        $channelToken = json_decode(file_get_contents(PLATFORM_DIR . 'token'), true)['channelToken'];
        $httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient($channelToken);
        $channelSecret = json_decode(file_get_contents(PLATFORM_DIR . 'token'), true)['channelSecret'];
        $lineBot = new LINE\LINEBot($httpClient, array('channelSecret' => $channelSecret));
        $this->lineBot = $lineBot;
    }
    /**
     * @param mixed $body
     * @param mixed $signature
     * @return LINE\LINEBot\Event\BaseEvent[]
     */
    // protected function parseEventRequest($body, $signature)
    // {
    //     return $this->lineBot->parseEventRequest($body, $signature);
    // }
    /**
     * 
     */
    protected function replyText($replyToken, $text, $extraTexts = null)
    {
        $this->lineBot->replyText($replyToken, $text, $extraTexts);
    }
}
