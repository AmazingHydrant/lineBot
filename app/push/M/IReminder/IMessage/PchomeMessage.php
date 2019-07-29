<?php

namespace IReminder\IMessage;

use IReminder\IMessage;

class PchomeMessage implements IMessage
{
    private $flagName = 'pchome';
    private $data;
    private $text;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function nowPush()
    {
        if (in_array($this->data, $this->getFlag())) {
            return false;
        } else {
            return true;
        }
    }

    public function getText()
    {
        $oldPrice = '';
        if ($this->getFlag()) {
            foreach ($this->getFlag() as $v) {
                if (explode(',', $v)[0] == explode(',', $this->data)[0]) {
                    $oldPrice = explode(',', $v)[1];
                    $oldPrice .= ' -> ';
                }
            }
        }
        return explode(',', $this->data)[0] . PHP_EOL . '價格 ' . $oldPrice . explode(',', $this->data)[1];
    }

    public function setFlag()
    {
        $flagPath =  PLATFORM_DIR . $this->flagName . '.flag';
        if (!file_exists($flagPath)) {
            file_put_contents($flagPath, json_encode([], JSON_FORCE_OBJECT));
        }
        $arr = [];
        $arr[] = $this->data;
        file_put_contents($flagPath, json_encode($arr, JSON_FORCE_OBJECT));
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
        $flagList = $this->getFlag();
        foreach ($flagList as $k => $v) {
            if (explode(',', $v)[0] == explode(',', $this->data)[0]) {
                unset($flagList[$k]);
            }
        }
        file_put_contents($flagPath, json_encode($flagList, JSON_FORCE_OBJECT));
    }

    public function getImgUrl()
    {
        return null;
    }
}
