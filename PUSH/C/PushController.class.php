<?php
class PushController
{
    public function pushEarthquake()
    {
        $userM = new UserModel;
        $to = $userM->getUserIdList();
        $weather = new WeatherModel;
        $push_M = new PushModel;
        if ($newRecords = $weather->getNewRecords()) {
            foreach ($newRecords as $v) {
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($v['reportType'], $v['reportContent']);
                $push_M->pushMessage($to, $textMessage);
                $imageMessage = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($v['reportImageURI'], $v['reportImageURI']);
                $push_M->pushMessage($to, $imageMessage);
            }
        }
    }
    public function pushStock()
    {
        $stock_M = new StockModel;
        $res = $stock_M->getStockInfo();
        $push_M = new PushModel;
        $userM = new UserModel;
        $to = $userM->getUserIdList();
        foreach ($res as $v) {
            if ($v['截止日期'] == date("n月j日")) {
                $text = "[抽股票]{$v['股票代號股票名稱']} 今天截止";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $push_M->pushMessage($to, $textMessage);
            }
        }
    }
    public function test()
    {
        $userM = new UserModel;
        $l = ['M', 'L'];
        $userM->deleteUserIds($l);
        $userlist = $userM->getUserIdList();
        var_dump($userlist);
        var_dump($userM->getDeletedUserId());
    }
}
