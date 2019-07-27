<?php

namespace IReminder;

interface IMessage
{
    /**
     * @return bool
     */
    public  function nowPush();
    /**
     * @return array
     */
    public  function getText();
}
