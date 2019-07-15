<?php
class PriceModel
{
    public function getPrice($goodName, $listNum = 3)
    {
        $strList = [];
        $url = "https://feebee.com.tw/all/{$goodName}";
        $xpath = "//ol[@id='list_view']/li[contains(@class,'pure-g')][position()<={$listNum}]/span[contains(@class,'items_container')]/a[@title]";
        $res = curl($url)->xp($xpath);
        foreach ($res as $k => $v) {
            $strList[$k]['titel'] =  $v->nodeValue;
        }
        $xpath = "//ol[@id='list_view']/li[contains(@class,'pure-g')][position()<={$listNum}]/span[contains(@class,'items_container')]/ul/li[1]/text()";
        $res = curl($url)->xp($xpath);
        foreach ($res as $k => $v) {
            $strList[$k]['price'] =  $v->nodeValue;
        }
        return $strList;
    }
}
