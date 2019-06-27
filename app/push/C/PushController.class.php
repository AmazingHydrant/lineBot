<?php
/**
 * push line message class
 */
class PushController extends Controller
{
    /**
     * @param UserModel $userM
     */
    protected $userM;
    protected $to;
    /**
     * @param PushModel $pushM
     */
    protected $pushM;
    protected $pushTimeHour = 15;
    protected $pushTimeMinute = 0;
    public function __construct()
    {
        $this->initModel();
    }
    /**
     * init UserModel & PushModle
     */
    protected function initModel()
    {
        $this->userM = new UserModel;
        $this->to = $this->userM->getUserIdList();
        $this->pushM = new PushModel;
    }
    /**
     * push newest earthquake info
     */
    public function pushEarthquake()
    {
        $weather = new WeatherModel;
        if ($newRecords = $weather->getNewRecords()) {
            foreach ($newRecords as $v) {
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($v['reportType'], $v['reportContent']);
                $this->pushM->pushMessage($this->to, $textMessage);
                $imageMessage = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($v['reportImageURI'], $v['reportImageURI']);
                $this->pushM->pushMessage($this->to, $imageMessage);
            }
        }
    }
    /**
     * push stock info
     */
    public function pushStock()
    {
        $stockM = new StockModel;
        $res = $stockM->getStockInfo();
        $remindHour = 22;
        $debitHour = 22;
        foreach ($res as $v) {
            if ($stockM->stockDateDiff($v['開始日期'], $remindHour) >= -5 && $stockM->stockDateDiff($v['開始日期'], $remindHour) < 0) {
                $text = "[抽股票]{$v['股票代號股票名稱']}" . PHP_EOL . "今天開始({$v['開始日期']})" . PHP_EOL;
                $text .= "參考價格 {$v['參考價格']}元" . PHP_EOL . "申購價格 {$v['申購價格']}元" . PHP_EOL;
                $text .= "抽中獲利 {$v['抽中獲利']}元" . PHP_EOL . "獲利率 {$v['獲利率']}";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->pushM->pushMessage($this->to, $textMessage);
            } elseif ($stockM->stockDateDiff($v['截止日期'], $remindHour) >= -5 && $stockM->stockDateDiff($v['截止日期'], $remindHour) < 0) {
                $text = "[抽股票]{$v['股票代號股票名稱']} 今天截止({$v['截止日期']})" . PHP_EOL;
                $text .= "抽中獲利 {$v['抽中獲利']}元 中籤率 {$v['中籤率']} 期望值 " . ((int)str_replace(",", "", $v['抽中獲利']) * (float)$v['中籤率'] / 100) . "元";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->pushM->pushMessage($this->to, $textMessage);
            } elseif ($stockM->stockDateDiff($v['預扣款日'], $debitHour, "-1 day") >= -5 && $stockM->stockDateDiff($v['預扣款日'], $debitHour, "-1 day") < 0) {
                $text = "[抽股票]{$v['股票代號股票名稱']} 今晚預扣款({$v['預扣款日']})" . PHP_EOL;
                $text .= "預扣費用 {$v['預扣費用']}元";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->pushM->pushMessage($this->to, $textMessage);
            }
        }
    }
    /**
     * push all
     */
    public function push()
    {
        $this->pushEarthquake();
        $this->pushStock();
    }
    /**
     * use HTTPget Method param "t" to send message 
     */
    public function text()
    {
        $text = isset($_GET['t']) ? $_GET['t'] : NULL;
        if (!$text) {
            die('缺少t參數');
        }
        $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $this->pushM->pushMessage($this->to, $textMessage);
    }
    /**
     * for test
     */
    public function test()
    {
        $str = "4.67%";
        $toint =  (float)$str;
        var_dump($toint);
    }
}
