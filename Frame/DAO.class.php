<?php
class DAO
{
    private $potion = [];
    private static $instance;
    private function __construct()
    { }
    public static function instance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
