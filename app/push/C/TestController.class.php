<?php

use IReminder\StockTestModel;

/**
 * push line message class
 */
class TestController extends Controller
{
    public function test()
    {
        $pushTM = new PushTestModel;
        $data = new StockTestModel;
        $pushTM->push($data);
    }
}
