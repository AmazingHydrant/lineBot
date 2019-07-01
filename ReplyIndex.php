<?php
require_once "/Frame/Frame.class.php";
$_GET['p'] = 'push';
$_GET['c'] = 'Reply';
$_GET['a'] = 'index';
Frame::run();
