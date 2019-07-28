<?php

namespace IReminder\IMessage;

use IReminder\IMessage;

class EarthquakeTestMessage implements IMessage
{
    private $flagName = 'earthquake';
    private $data;
    private $text;
    private $imageUrl;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function nowPush()
    {
        $earthquakeNo = $this->data['earthquakeNo'];
        if ($this->isPushed()) {
            return false;
        }
        $this->text = '[' . $this->data['reportType'] . ']' . PHP_EOL;
        $this->text .= $this->data['reportContent'];
        $this->imageUrl =  $this->data['reportImageURI'];
        return true;
    }

    public function getText()
    {
        if (!$this->text) {
            return $this->data;
        }
        return $this->text;
    }

    public function getImgUrl()
    {
        if (!$this->imageUrl) {
            return '';
        }
        return $this->imageUrl;
    }

    public function setFlag()
    {
        $flagPath =  PLATFORM_DIR . $this->flagName . '.flag';
        if (!file_exists($flagPath)) {
            file_put_contents($flagPath, json_encode([], JSON_FORCE_OBJECT));
        }
        file_put_contents($flagPath, json_encode([$this->data['earthquakeNo']], JSON_FORCE_OBJECT));
    }

    public function getFlag()
    {
        $flagPath =  PLATFORM_DIR . $this->flagName . '.flag';
        if (!file_exists($flagPath)) {
            return [];
        }
        return json_decode(file_get_contents($flagPath), true);
    }

    public function delFlag()
    {
        $flagPath =  PLATFORM_DIR . $this->flagName . '.flag';
        file_put_contents($flagPath, json_encode([], JSON_FORCE_OBJECT));
    }

    public function isPushed()
    {
        if (in_array($this->data['earthquakeNo'], $this->getFlag())) {
            return true;
        } else {
            return false;
        }
    }
}
