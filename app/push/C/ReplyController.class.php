<?php
class ReplyController
{
    public function index()
    {
        $replyModel = new ReplyModel;
        $replyModel->replyText('你好', 'You too.');
        $replyModel->replyText('好', 'Good.');
        // $replyModel = new ReplyModel;
        $textMessageEvent = $replyModel->getTextMessageEvent();
        foreach ($textMessageEvent as $text) {
            // if (mb_substr($text['text'], -1) == " ") {
            switch (explode(" ", $text['text'])[0]) {
                case '查':
                    $str = '';
                    foreach (PriceM()->getPrice(explode(" ", $text['text'])[1], 3) as $v) {
                        $str .= trim($v['titel']) . " $" . trim($v['price']) . "\r\n";
                    }
                    $str = trim($str, "\r\n");
                    $replyModel->reply($text['replyToken'], $str);
                    break;
                default:
                    break;
            }
            // }
        }
    }
}
