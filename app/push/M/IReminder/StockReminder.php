<?php

namespace IReminder;

use IReminder;
use Curl;
use IReminder\IMessage\StockTestMessage;

class StockReminder implements IReminder
{
    /**
     * @return string[]
     */
    public function getBasicData()
    {
        $curl = new Curl;
        $url = 'https://stockluckydraw.com/StockInfoTable.htm';
        $html = $curl->getHtml($url);
        $stockNo = 0;
        $stockList = [];
        for ($center = 1; $center <= 3; $center++) {
            for ($tr = 1; $tr < 20; $tr++) {
                $stockXpath = "//center/center[$center]/table/tr[$tr]/td";
                $stock = $curl->xpath($html, $stockXpath);
                if (!$stock->length) {
                    break;
                }
                if ($tr == 1) {
                    $titleList = [];
                    foreach ($stock as $v) {
                        $titleList[] = $v->nodeValue;
                    }
                } else {
                    foreach ($stock as $k => $v) {
                        $stockList[$stockNo][$titleList[$k]] =  $v->nodeValue;
                    }
                    $stockNo += 1;
                }
            }
        }
        return $stockList;
    }

    /**
     * @return StockTestMessage[]
     */
    public function getData()
    {
        $iMessageList = [];
        foreach ($this->getBasicData()  as $data) {
            $iMessageList[] = new StockTestMessage($data);
        }
        return $iMessageList;
    }

    public function getPushList()
    {
        return M('User')->getReminderUserIdList('stock');
    }
}
