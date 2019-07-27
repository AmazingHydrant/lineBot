<?php

use IReminder\StockReminder;
use IReminder\EarthquakeReminder;

/**
 * push line message class
 */
class PushController extends Controller
{
    /**
     * push all
     */
    public function push()
    {
        $pushTM = new PushTestModel;
        $stockReminder = new StockReminder;
        $pushTM->PushReminder($stockReminder);
        $weatherReminder = new EarthquakeReminder;
        $pushTM->PushReminder($weatherReminder);
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
        $pushM = new PushModel;
        $pushM->pushMessage('all', $textMessage);
    }
    /**
     * for test
     */
    public function test()
    {
        $str = '';
        foreach (PriceM()->getPrice('USB', 3) as $v) {
            $str .= trim($v['titel']) . " $" . trim($v['price']) . "\r\n";
        }
        $str = trim($str, "\r\n");
        p($str);
    }
}
