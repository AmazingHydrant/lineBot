<?php

class PushTestModel
{
    public function Push(IReminder $data)
    {
        /**
         * @var IReminder $messages
         */
        $messages = $data->getData();
        foreach ($messages as $message) {
            echo '<br/>';
            p($message->nowPush());
            echo '<br/>';
            p($message->text());
            echo '<hr/>';
        }
    }
}
