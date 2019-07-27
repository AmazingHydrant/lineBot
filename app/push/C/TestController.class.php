<?php

use IReminder\StockReminder;
use IReminder\EarthquakeReminder;

/**
 * push line message class
 */
class TestController extends Controller
{
    public function test()
    {
        $pushTM = new PushTestModel;
        $stockReminder = new StockReminder;
        $pushTM->PushReminder($stockReminder);
        $weatherReminder = new EarthquakeReminder;
        $pushTM->PushReminder($weatherReminder);
    }
}
