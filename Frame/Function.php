<?php

/**
 * echo and die
 */
function dd($data)
{
    if (is_bool($data) or is_null($data) or is_object($data)) {
        var_dump($data);
    } else {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    die;
}
/**
 * print
 */
function p($data)
{
    if (is_bool($data) or is_null($data) or is_object($data)) {
        var_dump($data);
    } else {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
/**
 * @return PriceModel
 */
function PriceM()
{
    return new PriceModel;
}
/**
 * @return Curl
 */
function curl($url)
{
    return F("Curl", $url);
}
function F($obj, $param = null)
{
    static $objList = [];
    if (!isset($objList[$obj])) {
        $objList[$obj] = new $obj($param);
    }
    return $objList[$obj];
}
function M($modelName)
{
    return F($modelName . 'Model');
}
function tt($data)
{
    $this->logM->putLog("tt.txt", $data);
}
