<?php

interface IReminder
{
    /**
     * @return IReminder\IMessage
     */
    public function getData();

    /**
     * @return Array
     */
    public function getPushList();
}
