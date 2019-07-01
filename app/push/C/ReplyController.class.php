<?php
class ReplyController
{
    public function index()
    {
        $replyModel = new ReplyModel;
        $replyModel->test();
    }
}
