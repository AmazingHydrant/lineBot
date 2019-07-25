<?php

namespace IReminder\IMessage;

use IReminder\IMessage;

class StockTestMessageModel implements IMessage
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public  function nowPush()
    {
        if ($this->data['開始日期'] == date('n月j日')) {
            echo '今天開始' . date('n月j日');
            return true;
        } else {
            echo '不是今天開始';
            return false;
        }
    }
    public  function text()
    {
        // $str = '股票名稱:' . $this->data['股票代號股票名稱'] . PHP_EOL;
        // $str .= '獲利率:' . $this->data['獲利率'] . PHP_EOL;
        // $str .= '抽中獲利:' . $this->data['抽中獲利'];
        $str = $this->data;
        return $str;
    }
}
