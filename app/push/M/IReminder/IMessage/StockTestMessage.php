<?php

namespace IReminder\IMessage;

use IReminder\IMessage;

class StockTestMessage implements IMessage
{
    private $flagName = 'stock';
    private $data;
    private $text;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function nowPush()
    {
        if ($this->data['開始日期'] == date('n月j日') and date('H') == '10') {
            if (isPushed()) {
                return false;
            }
            $this->text = "[抽股票開始通知]. PHP_EOL .{$this->data['股票代號股票名稱']}" . PHP_EOL . "今天開始 {$this->data['開始日期']}" . PHP_EOL;
            $this->text .= "參考價格 {$this->data['參考價格']}元" . PHP_EOL . "申購價格 {$this->data['申購價格']}元" . PHP_EOL;
            $this->text .= "抽中獲利 {$this->data['抽中獲利']}元" . PHP_EOL . "獲利率 {$this->data['獲利率']}";
            return true;
        } elseif ($this->data['截止日期'] == date('n月j日') and date('H') == '10') {
            if (isPushed()) {
                return false;
            }
            $this->text = "[抽股票截止通知]. PHP_EOL .{$this->data['股票代號股票名稱']}" . PHP_EOL . "今天截止 {$this->data['截止日期']}" . PHP_EOL;
            if ($this->data['中籤率'] == '') {
                $this->text .= "抽中獲利 {$this->data['抽中獲利']}元" . PHP_EOL . "中籤率 尚未公佈";
            } else {
                $this->text .= "抽中獲利 {$this->data['抽中獲利']}元" . PHP_EOL . "中籤率 {$this->data['中籤率']}" . PHP_EOL . "期望值 " . ((int) str_replace(",", "", $this->data['抽中獲利']) * (float) $this->data['中籤率'] / 100) . "元";
            }
            return true;
        } elseif ($this->data['預扣款日'] == date('n月j日') and date('H') == '22') {
            if (isPushed()) {
                return false;
            }
            $this->text = "[抽股票扣款通知]. PHP_EOL .{$this->data['股票代號股票名稱']}" . PHP_EOL . "今晚預扣款 {$this->data['預扣款日']}" . PHP_EOL;
            $this->text .= "預扣費用 {$this->data['預扣費用']}元";
            return true;
        } else {
            $this->delFlag();
            return false;
        }
    }

    public function getText()
    {
        if (!$this->text) {
            return $this->data;
        }
        return $this->text;
    }

    public function setFlag()
    {
        $flagPath =  PLATFORM_DIR . $this->flagName . '.flag';
        if (!file_exists($flagPath)) {
            file_put_contents($flagPath, json_encode([], JSON_FORCE_OBJECT));
        }
        file_put_contents($flagPath, json_encode([$this->data['股票代號股票名稱']], JSON_FORCE_OBJECT));
    }

    public function getFlag()
    {
        $flagPath =  PLATFORM_DIR . $this->flagName . '.flag';
        if (!file_exists($flagPath)) {
            return [];
        }
        return json_decode(file_get_contents($flagPath), true);
    }

    public function delFlag()
    {
        $flagPath =  PLATFORM_DIR . $this->flagName . '.flag';
        $flagList = $this->getFlag();
        foreach ($flagList as $k => $v) {
            if ($v == $this->data['股票代號股票名稱']) {
                unset($flagList[$k]);
            }
        }
        file_put_contents($flagPath, json_encode($flagList, JSON_FORCE_OBJECT));
    }

    public function isPushed()
    {
        if (in_array($this->data['股票代號股票名稱'], $this->getFlag())) {
            return true;
        } else {
            return false;
        }
    }
}
