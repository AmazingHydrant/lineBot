<?php
class WeatherModel
{
    public function __construct()
    {
        $this->initConst();
        $this->initFile();
    }
    private function initConst()
    {
        define('EARTHQUAKE_URL', 'https://opendata.cwb.gov.tw/api/v1/rest/datastore/E-A0015-001?Authorization=CWB-A6B34091-3A76-4E4A-9FC2-103D013D1D9E');
        define('EATHQUAKE_NAME', 'eathquake_db.json');
        define('EATHQUAKE_DB_PATH', PLATFORM_DIR . EATHQUAKE_NAME);
    }
    private function initFile()
    {
        if (!file_exists(EATHQUAKE_DB_PATH)) {
            file_put_contents(EATHQUAKE_DB_PATH, json_encode(json_decode("{}")));
        }
    }
    public function getRecords()
    {
        $curl = new Curl;
        $json = $curl->getHtml(EARTHQUAKE_URL);
        return json_decode($json, true);
    }
    public function getNewRecords()
    {
        $records = $this->getRecords();
        static $res = [];
        $db = json_decode(file_get_contents(EATHQUAKE_DB_PATH), true);
        if (isset($records['records']['earthquake'])) {
            foreach ($records['records']['earthquake'] as $val) {
                if (!isset($db['earthquakeNo']) or !in_array($val['earthquakeNo'], $db['earthquakeNo'])) {
                    $db['earthquakeNo'][] = $val['earthquakeNo'];
                    file_put_contents(EATHQUAKE_DB_PATH, json_encode($db));
                    $res[$val['earthquakeNo']]['reportType'] = $val['reportType'];
                    $res[$val['earthquakeNo']]['reportContent'] = $val['reportContent'];
                    $res[$val['earthquakeNo']]['reportImageURI'] = $val['reportImageURI'];
                }
            }
            return $res;
        } else {
            unset($db['earthquakeNo']);
            return false;
        }
    }
}
