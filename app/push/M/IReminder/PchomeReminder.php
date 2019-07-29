<?php

namespace IReminder;

use IReminder;
use Curl;
use IReminder\IMessage\PchomeMessage;

class PchomeReminder implements IReminder
{
    /**
     * @return PchomeMessage[]
     */
    public function getData()
    {
        $curl = new Curl;
        $url = 'https://24h.pchome.com.tw/ecapi/ecshop/prodapi/v2/prod/DYAF53-A9006L6O0-000&store=DYAPC3&fields=Name,Nick,Price,Pic&_callback=jsonp_prod&1564372260?_callback=jsonp_prod';
        $html = $curl->getHtml($url);
        $json = explode(";", $html)[0];
        $json = str_replace('try{jsonp_prod(', '', $json);
        $json = str_replace('})', '}', $json);
        $arr = json_decode($json, true);
        $data = $arr['DYAF53-A9006L6O0-000']['Name'] . ',' . $arr['DYAF53-A9006L6O0-000']['Price']['P'];
        $iMessageList[] = new PchomeMessage($data);
        return $iMessageList;
    }

    public function getPushList()
    {
        return M('User')->getAdminIdList();
    }
}
