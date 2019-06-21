<?php
class LogModel
{
    private $logPath;
    public function __construct()
    {
        $this->initConst();
    }
    private function initConst()
    {
        define('LOG_ROOT', ROOT_DIR . 'log/');
    }
    /**
     * @param string $logName init log file
     */
    private function initFile($logName)
    {
        if (!is_dir(LOG_ROOT)) {
            mkdir(LOG_ROOT);
        }
        $this->logPath = LOG_ROOT . $logName;
        if (!file_exists($this->logPath)) {
            file_put_contents($this->logPath, '');
        }
    }
    // public function putEarthquakePushLog($userIds, LINE\LINEBot\MessageBuilder $messageBuilder)
    // {
    //     $this->logName = 'Earthquake.txt';
    //     foreach ($messageBuilder->buildMessage() as $message) {
    //         switch ($message['type']) {
    //             case 'text':
    //                 $this->putLog($this->logName, date('Y-m-d H:i:s') . " [" . implode(',', $userIds) . "]:[{$message['type']}]{$message['text']}");
    //                 break;
    //             case 'image':
    //                 $this->putLog($this->logName, date('Y-m-d H:i:s') . " [" . implode(',', $userIds) . "]:[{$message['type']}]{$message['originalContentUrl']}");
    //                 break;
    //             default:
    //                 $this->putLog($this->logName, date('Y-m-d H:i:s') . " [" . implode(',', $userIds) . "]:[{$message['type']}]" . implode(',', $message));
    //         }
    //     }
    // }

    /**
     * @param string $logName log file name
     * @param string $text text
     */
    public function putLog($logName, $text)
    {
        $this->initFile($logName);
        file_put_contents($this->logPath, date('Y-m-d H:i:s') . ' ' . $text . PHP_EOL, FILE_APPEND);
    }
}
