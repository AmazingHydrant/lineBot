<?php

// use IReminder\IMessage;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;

class PushTestModel
{
    public function PushReminder(IReminder $reminder)
    {
        $userList = $reminder->getPushList();
        $messages = $reminder->getData();
        foreach ($messages as $message) {
            if ($message->nowPush()) {
                $textMessage = new TextMessageBuilder($message->getText());
                $pushM = new PushModel;
                $pushM->pushMessage($userList, $textMessage);
                if ($message->getImgUrl()){
                    $imageMessage = new ImageMessageBuilder($message->getImgUrl(), $message->getImgUrl());
                    $pushM->pushMessage($userList, $imageMessage);    
                }
                $message->setFlag();
                p($userList);
                echo $message->getText();
                echo $message->getImgUrl();
            }
        }
    }
}
