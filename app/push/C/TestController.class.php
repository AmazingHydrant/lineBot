<?php

/**
 * push line message class
 */
class TestController extends Controller
{
    public function test()
    {
        $flyModel = new FlyModel;
        $res = $flyModel->getHtml();
        dd($res);
    }
}
