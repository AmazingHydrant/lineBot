<?php

use IReminder\PchomeReminder;

/**
 * push line message class
 */
class TestController extends Controller
{
    public function test()
    {
        $pushTM = new PushTestModel;
        $pchomeReminder = new PchomeReminder;
        $pushTM->PushReminder($pchomeReminder);
    }
}
