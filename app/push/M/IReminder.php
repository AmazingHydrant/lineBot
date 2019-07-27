<?php

interface IReminder
{
    /**
     * @return IReminder\IMessage
     */
    public function getData();
}
