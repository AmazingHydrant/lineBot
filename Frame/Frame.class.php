<?php
class Frame
{
    public static function run()
    {
        self::initTimeZone();
        self::initConst();
        self::initDispatchParam();
        self::initPlatformConst();
        self::initBaseFunction();
        self::initAutoLoad();
        self::initDispatch();
    }
    private static function initTimeZone()
    {
        date_default_timezone_set("Asia/Taipei");
    }
    private static function initConst()
    {
        define('ROOT_DIR', getcwd() . '/');
        define('APP_DIR', ROOT_DIR . 'app/');
        define('Frame_DIR', ROOT_DIR . 'frame/');
        define('PUBLIC_DIR', '/public/');
    }
    private static function initDispatchParam()
    {
        $default_platform = 'admin';
        $platform = isset($_GET['p']) ? $_GET['p'] : $default_platform;
        define('PLATFORM', $platform);
        $default_controller = 'admin';
        $controller = isset($_GET['c']) ? $_GET['c'] : $default_controller;
        define('CONTROLLER', $controller);
        $default_action = 'login';
        $action = isset($_GET['a']) ? $_GET['a'] : $default_action;
        define('ACTION', $action);
    }
    private static function initPlatformConst()
    {
        define('PLATFORM_DIR', APP_DIR . PLATFORM . '/');
        define('M_DIR', PLATFORM_DIR . 'M/');
        define('C_DIR', PLATFORM_DIR . 'C/');
        define('V_DIR', PLATFORM_DIR . 'V/');
        define('CSS_DIR', PUBLIC_DIR . PLATFORM . '/css/');
        define('JS_DIR', PUBLIC_DIR  . PLATFORM . '/js/');
        define('ICON_DIR', PUBLIC_DIR  . PLATFORM . '/icon/');
    }
    private static function initBaseFunction()
    {
        require_once Frame_DIR . 'Function.php';
    }
    private static function initAutoLoad()
    {
        function autoLoad($calssName)
        {
            $FrameClassList = [
                'Frame' => Frame_DIR . 'Frame.class.php',
                'Tool' => Frame_DIR . 'Tool.class.php',
                'Curl' => Frame_DIR . 'Curl.class.php',
                'DAO' => Frame_DIR . 'DAO.class.php',
                'PDODB' => Frame_DIR . 'PDODB.class.php',
                'Controller' => Frame_DIR . 'Controller.class.php',
            ];
            if (isset($FrameClassList[$calssName])) {
                require_once $FrameClassList[$calssName];
            } elseif (mb_substr($calssName, -10) == 'Controller') {
                //if platform and controller not exists
                if (!file_exists(C_DIR . $calssName . '.class.php')) {
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    die;
                }
                require_once C_DIR . $calssName . '.class.php';
            } elseif (mb_substr($calssName, -5) == 'Model') {
                require_once M_DIR . $calssName . '.class.php';
            } elseif (mb_substr($calssName, 0, 4) == 'LINE') {
                require_once ROOT_DIR . mb_substr($calssName, 5) . '.php';
            } else {
                echo 'unknow class name ';
            }
        }
        spl_autoload_register('autoLoad');
    }
    private static function initDispatch()
    {

        $controller = CONTROLLER . 'Controller';
        $c = new $controller;
        if (method_exists($c, ACTION)) {
            $action = ACTION;
            $c->$action();
        }
        //if action not exists
        else {
            header('Location: ' . $_SERVER['PHP_SELF']);
            die;
        }
    }
}
