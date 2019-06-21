<?php
require_once "/Frame/Frame.class.php";
$_GET['p'] = 'push';
$_GET['c'] = 'push';
$_GET['a'] = 'pushEarthquake';
Frame::run();
