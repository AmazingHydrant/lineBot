<?php
class StockModel
{
    public function getStockInfo()
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
     * @param array $date [int $hour, int $minute, int $second, int $month, int $day, int $year]
     * @return int|bool Seconds
     */
    public function timeDiff($date, $strtotime = "+0 second")
    {
        $hour = is_integer($date['hour']) ? $date['hour'] : (int)date("H");
        $minute = is_integer($date['minute']) ? $date['minute'] : (int)date("i");
        $second = is_integer($date['second']) ? $date['second'] : (int)date("s");
        $month = is_integer($date['month']) ? $date['month'] : (int)date("n");
        $day = is_integer($date['day']) ? $date['day'] : (int)date("j");
        $year = is_integer($date['year']) ? $date['year'] : (int)date("Y");
        if ($setTime = mktime($hour, $minute, $second, $month, $day, $year)) {
            if ($setTime = strtotime(" $strtotime", $setTime)) {
                $diffTime = $setTime - time();
                return $diffTime;
            }
        }
        return false;
    }
    /**
     * @param string $date 'n月j日'
     * @param int $hour 0-23
     * @param string $strtotime like +1 day | -2 hour etc..
     * @return int|bool minute
     */
    public function stockDateDiff($date, $hour, $strtotime = "-0 second")
    {
        $arrayDate = date_parse_from_format('n月j日', $date);
        $arrayDate['hour'] =  $hour;
        $arrayDate['minute'] =  0;
        $arrayDate['second'] =  0;
        $diffTime =  $this->timeDiff($arrayDate, $strtotime);
        return $diffTime / 60;
    }
}
