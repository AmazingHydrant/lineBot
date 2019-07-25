<?php
require_once "/Frame/Frame.class.php";
$_GET['p'] = 'push';
$_GET['c'] = 'Test';
$_GET['a'] = 'test';
Frame::run();
