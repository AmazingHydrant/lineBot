<?php
/**
 * 
 */
class Curl
{
    public function __construct()
    {
        $this->init();
    }
    private function init()
    {
        $timeout_sec = '10';
        ini_set("max_execution_time", $timeout_sec);
    }
    /**
     * @param string $url
     */
    public function getHtml($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        //curl_setopt($ch,CURLOPT_POSTFIELDS,$data); //设置post的参数
        //curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded;charset=utf-8','Content-length: '.strlen($data)));
        //curl_setopt($ch, CURLOPT_USERAGENT, "user-agent:Mozilla/5.0 (Windows NT 5.1; rv:24.0) Gecko/20100101 Firefox/24.0"); //解决错误：“未将对象引用设置到对象的实例。”
        $res = curl_exec($ch);
        if (!$res) {
            file_put_contents(ROOT_DIR . "/log/curlErrLog.txt", date('Y-m-d H:i:s') . ' curl error: ' . curl_error($ch) . PHP_EOL, FILE_APPEND);
            return false;
        }
        curl_close($ch);
        return $res;
    }
    /**
     * @param string $html html
     * @param string $xpath xpath query
     */
    public function xpath($html, $xpath)
    {
        // create document object model
        $dom = new DOMDocument();
        // load html into document object model
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        // create domxpath instance
        $domXPath = new DOMXPath($dom);
        // get all elements with a particular id and then loop through and print the href attribute
        $elements = $domXPath->query($xpath);
        return $elements;
    }
}
