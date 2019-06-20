<?php
class PushController extends Controller
{
    public function pushEarthquake()
    {
        $weather = new WeatherModel;
        if ($newRecords = $weather->getNewRecords()) {
            foreach ($newRecords as $v) {
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($v['reportType'], $v['reportContent']);
                $this->push_M->pushMessage($this->to, $textMessage);
                $imageMessage = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($v['reportImageURI'], $v['reportImageURI']);
                $this->push_M->pushMessage($this->to, $imageMessage);
            }
        }
    }
    public function pushStock()
    {
        $stock_M = new StockModel;
        $res = $stock_M->getStockInfo();
        foreach ($res as $v) {
            if ($v['截止日期'] == date("n月j日")) {
                $text = "[抽股票]{$v['股票代號股票名稱']} 今天截止";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->push_M->pushMessage($this->to, $textMessage);
            }
        }
    }
    public function text()
    {
        $text = isset($_GET['t']) ? $_GET['t'] : NULL;
        if (!$text) {
            die('缺少t參數');
        }
        $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $this->push_M->pushMessage($this->to, $textMessage);
    }
    public function test()
    {
        $l = ['M', 'L'];
        $this->userM->deleteUserIds($l);
        $userlist = $this->userM->getUserIdList();
        var_dump($userlist);
        var_dump($this->userM->getDeletedUserId());
    }
}
