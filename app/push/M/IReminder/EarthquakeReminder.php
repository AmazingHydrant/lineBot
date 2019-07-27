<?php

namespace IReminder;

use IReminder;
use Curl;
use IReminder\IMessage\EarthquakeTestMessage;

class EarthquakeReminder implements IReminder
{
    public function getBasicData()
    {
        $curl = new Curl;
        $url = 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/E-A0015-001?Authorization=CWB-A6B34091-3A76-4E4A-9FC2-103D013D1D9E';
        $json = $curl->getHtml($url);
        return json_decode($json, true);
    }

    public function getData()
    {
        $iMessageList = [];
        foreach ($this->getBasicData()['records']['earthquake']  as $data) {
            if (!$data) {
                $earthquakeTestMessage =  new EarthquakeTestMessage(null);
                $earthquakeTestMessage->delFlag();
                return $iMessageList;
            }
            $iMessageList[] = new EarthquakeTestMessage($data);
        }
        return $iMessageList;
    }

    public function getPushList()
    {
        return M('User')->getReminderUserIdList('earthquake');
    }
}
