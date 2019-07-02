<?php
class ReplyController
{
    public function index()
    {
        $replyModel = new ReplyModel;
        $replyModel->replyText('你好', 'You too.');
        $replyModel->replyText('好', 'Good.');

        // $replyModel = new ReplyModel;
        // $textMessageEvent = $replyModel->getTextMessageEvent();
        // foreach ($textMessageEvent as $text) {
        //     switch ($text['text']) {
        //         case '你好':
        //             $replyModel->reply($text['replyToken'], 'You too');
        //             break;
        //         default:
        //             break;
        //     }
        // }
    }
}
