<?php
/**
 * push line message class
 */
class PushController extends Controller
{
    /**
     * @param UserModel $userM
     */
    protected $userM;
    protected $to;
    /**
     * @param PushModel $pushM
     */
    protected $pushM;
    public function __construct()
    {
        $this->initModel();
    }
    /**
     * init UserModel & PushModle
     */
    protected function initModel()
    {
        $this->userM = new UserModel;
        $this->to = $this->userM->getUserIdList();
        $this->pushM = new PushModel;
    }
    /**
     * push newest earthquake info
     */
    public function pushEarthquake()
    {
        $weather = new WeatherModel;
        if ($newRecords = $weather->getNewRecords()) {
            foreach ($newRecords as $v) {
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($v['reportType'], $v['reportContent']);
                $this->pushM->pushMessage($this->to, $textMessage);
                $imageMessage = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($v['reportImageURI'], $v['reportImageURI']);
                $this->pushM->pushMessage($this->to, $imageMessage);
            }
        }
    }
    /**
     * push stock info
     */
    public function pushStock()
    {
        $stock_M = new StockModel;
        $res = $stock_M->getStockInfo();
        foreach ($res as $v) {
            if ($v['截止日期'] == date("n月j日")) {
                $text = "[抽股票]{$v['股票代號股票名稱']} 今天截止";
                $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $this->pushM->pushMessage($this->to, $textMessage);
            }
        }
    }
    /**
     * use HTTPget Method param "t" to send message 
     */
    public function text()
    {
        $text = isset($_GET['t']) ? $_GET['t'] : NULL;
        if (!$text) {
            die('缺少t參數');
        }
        $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
        $this->pushM->pushMessage($this->to, $textMessage);
    }
    /**
     * for test
     */
    public function test()
    {
        // $l = [''];
        // $this->userM->addUserIds($l);
        var_dump($_POST);
    }
    public function managerPush()
    {
        if ($text = $_POST['text']) {
            switch ($_POST['to']) {
                case 'all':
                    break;
                default:
                    $this->to = $_POST['to'];
            }
            $textMessage = new LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            $this->pushM->pushMessage($this->to, $textMessage);
        }
        $this->jump('admin', 'Manager', 'index', $text);
        die;
    }
}
