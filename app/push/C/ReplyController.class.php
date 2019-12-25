<?php
class ReplyController
{
    public function index()
    {
        // test switch
        // ReplyModel::$test = true;

        $replyModel = new ReplyModel;
        $text = explode(" ", $replyModel->getText(), 2);
        if (count($text) > 1) {
            $extraTexts = $text[1];
        }
        $text = $text[0];
        switch ($text) {
            case '1':
                $replyModel->reply($extraTexts);
                break;
            case '開啟地震':
                $userId = $replyModel->getUserId();
                if (M('User')->setEarthquakeRemine($userId)) {
                    $replyModel->reply('開啓地震通知');
                } else {
                    $replyModel->reply('發生錯誤，請稍後再試');
                }
                break;
            case '關閉地震':
                $userId = $replyModel->getUserId();
                if (M('User')->delEarthquakeRemine($userId)) {
                    $replyModel->reply('關閉地震通知');
                } else {
                    $replyModel->reply('發生錯誤，請稍後再試');
                }
                break;
            case '開啟股票':
                $userId = $replyModel->getUserId();
                if (M('User')->setStockRemine($userId)) {
                    $replyModel->reply('開啟股票通知');
                } else {
                    $replyModel->reply('發生錯誤，請稍後再試');
                }
                break;
            case '關閉股票':
                $userId = $replyModel->getUserId();
                if (M('User')->delStockRemine($userId)) {
                    $replyModel->reply('關閉股票通知');
                } else {
                    $replyModel->reply('發生錯誤，請稍後再試');
                }
                break;
            case '推送狀態':
                $userId = $replyModel->getUserId();
                if ($remines = M('User')->checkUserRemine($userId)) {
                    $remineStr = '';
                    foreach ($remines as $k => $v) {
                        if ($v) {
                            $remineStr .= "{$k} 開啓" . PHP_EOL;
                        } else {
                            $remineStr .= "{$k} 關閉" . PHP_EOL;
                        }
                    }
                } else {
                    $replyModel->reply('沒有開啓任何推送');
                    break;
                }
                $remineStr = trim($remineStr, PHP_EOL);
                $replyModel->reply($remineStr);
                break;
            case '查':
                $str = '';
                foreach (PriceM()->getPrice($extraTexts, 3) as $v) {
                    $str .= trim($v['titel']) . " $" . trim($v['price']) . "\r\n\r\n";
                }
                $str = trim($str, "\r\n");
                $replyModel->reply($str);
                break;
            default:
                break;
        }
    }
}
