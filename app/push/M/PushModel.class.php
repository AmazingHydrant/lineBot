<?php
class PushModel extends LineBotModel
{
    /**
     * @param UserModel $userM
     */
    private $userM;
    private $to;
    /**
     * @param LogModel $logM
     */
    private $logM;
    /**
     * not used yet for push time
     */
    private $pushTimeHour = 15;
    private $pushTimeMinute = 0;
    private $pushTimeLimit = 5;
    public function __construct()
    {
        parent::__construct();
        $this->initModel();
    }
    /**
     * init UserModel & PushModle
     */
    private function initModel()
    {
        $this->userM = new UserModel;
        $this->to = $this->userM->getUserIdList();
        $this->logM = new LogModel;
    }
    /**
     * push message and add log
     * @param array $userList to
     * @param LINE\LINEBot\MessageBuilder $userList $messageBuilder
     */
    public function pushMessage($userList, LINE\LINEBot\MessageBuilder $messageBuilder)
    {
        if ($userList == 'all') {
            $userList = $this->to;
        }
        foreach ($userList as $to) {
            $response = parent::pushMessage($to, $messageBuilder);
            $message = $messageBuilder->buildMessage();
            $jsonMessage = json_encode($message, JSON_UNESCAPED_UNICODE);
            if ($response->isSucceeded()) {
                $this->logM->putLog('pushMessage.txt', "{$jsonMessage} to {$to}");
            } else {
                $this->logM->putLog('pushMessage.txt', "[傳送失敗:{$response->getHTTPStatus()}] {$jsonMessage} to {$to}");
            }
        }
    }
    /**
     * push newest earthquake info
     */
    public function pushEarthquake()
    {
        $weather = new WeatherModel;
        if ($newRecords = $weather->getNewRecords()) {
            $to = M('User')->getEarthquakeUserIdList();
            foreach ($newRecords as $v) {
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($v['reportType'], $v['reportContent']);
                $this->pushMessage($to, $textMessage);
                $imageMessage = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($v['reportImageURI'], $v['reportImageURI']);
                $this->pushMessage($to, $imageMessage);
            }
        }
    }
    /**
     * push stock info
     */
    public function pushStock($remindHour = 10, $debitHour = 22, $pushDelay = 5)
    {
        $stockM = new StockModel;
        $res = $stockM->getStockInfo();
        $to = M('User')->getStockUserIdList();
        foreach ($res as $v) {
            if ($stockM->stockDateDiff($v['開始日期'], $remindHour) >= -1 * $pushDelay && $stockM->stockDateDiff($v['開始日期'], $remindHour) < 0) {
                $text = "[抽股票]{$v['股票代號股票名稱']}" . PHP_EOL . "今天開始 {$v['開始日期']}" . PHP_EOL;
                $text .= "參考價格 {$v['參考價格']}元" . PHP_EOL . "申購價格 {$v['申購價格']}元" . PHP_EOL;
                $text .= "抽中獲利 {$v['抽中獲利']}元" . PHP_EOL . "獲利率 {$v['獲利率']}";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->pushMessage($to, $textMessage);
            } elseif ($stockM->stockDateDiff($v['截止日期'], $remindHour) >= -1 * $pushDelay && $stockM->stockDateDiff($v['截止日期'], $remindHour) < 0) {
                $text = "[抽股票]{$v['股票代號股票名稱']}" . PHP_EOL . "今天截止 {$v['截止日期']}" . PHP_EOL;
                $text .= "抽中獲利 {$v['抽中獲利']}元" . PHP_EOL . "中籤率 {$v['中籤率']}" . PHP_EOL . "期望值 " . ((int) str_replace(",", "", $v['抽中獲利']) * (float) $v['中籤率'] / 100) . "元";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->pushMessage($to, $textMessage);
            } elseif ($stockM->stockDateDiff($v['預扣款日'], $debitHour, "-1 day") >= -1 * $pushDelay && $stockM->stockDateDiff($v['預扣款日'], $debitHour, "-1 day") < 0) {
                $text = "[抽股票]{$v['股票代號股票名稱']}" . PHP_EOL . "今晚預扣款 {$v['預扣款日']}" . PHP_EOL;
                $text .= "預扣費用 {$v['預扣費用']}元";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->pushMessage($to, $textMessage);
            }
        }
    }
}
