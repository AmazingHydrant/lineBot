<?php
class UserModel
{
    private $usersInfo = [];
    public function __construct()
    {
        $this->initConst();
        $this->initFile();
    }
    private function initConst()
    {
        define('USER_DB_NAME', 'line_users.json');
        define('USER_DB_PATH', PLATFORM_DIR . USER_DB_NAME);
    }
    private function initFile()
    {
        if (!file_exists(USER_DB_PATH)) {
            file_put_contents(USER_DB_PATH, json_encode([], JSON_FORCE_OBJECT));
        }
        $this->usersInfo = json_decode(file_get_contents(USER_DB_PATH), true);
    }
    public function getUserIdList()
    {
        $userIdList = [];
        if (count($this->usersInfo) === 0) {
            echo 'No user info.';
            return false;
        } else {
            foreach ($this->usersInfo as $key => $val) {
                if (isset($val['del']) and $val['del'] == 1) {
                    continue;
                }
                $userIdList[] = $key;
            }
        }
        return $userIdList;
    }
    public function getEarthquakeUserIdList()
    {
        $userIdList = [];
        if (count($this->usersInfo) === 0) {
            echo 'No user info.';
            return false;
        } else {
            foreach ($this->usersInfo as $key => $val) {
                if (isset($val['remine']['earthquake']) and $val['remine']['earthquake']) {
                    $userIdList[] = $key;
                } else {
                    continue;
                }
            }
        }
        return $userIdList;
    }
    public function getStockUserIdList()
    {
        $userIdList = [];
        if (count($this->usersInfo) === 0) {
            echo 'No user info.';
            return false;
        } else {
            foreach ($this->usersInfo as $key => $val) {
                if (isset($val['remine']['stock']) and $val['remine']['stock']) {
                    $userIdList[] = $key;
                } else {
                    continue;
                }
            }
        }
        return $userIdList;
    }
    /**
     * @param string $userID
     */
    public function addUserId($userID)
    {
        $this->usersInfo[$userID] = [];
        file_put_contents(USER_DB_PATH, json_encode($this->usersInfo, JSON_FORCE_OBJECT));
    }
    /**
     * if is new user addUser default status [del] = 1
     */
    public function findNewUser($userID)
    {
        if (!in_array($userID, $this->getUserIdList())) {
            $this->usersInfo[$userID] = ['del' => 1];
            file_put_contents(USER_DB_PATH, json_encode($this->usersInfo, JSON_FORCE_OBJECT));
        }
    }
    /**
     * @param array $userIDs
     */
    public function addUserIds($userIDs)
    {
        foreach ($userIDs as $userID) {
            $this->addUserId($userID);
        }
    }
    /**
     * @param string $userID
     */
    public function deleteUserId($userID)
    {
        if (!isset($this->usersInfo[$userID])) {
            echo "{$userID} 不存在";
            return false;
        }
        $this->usersInfo[$userID] = ['del' => '1'];
        file_put_contents(USER_DB_PATH, json_encode($this->usersInfo, JSON_FORCE_OBJECT));
    }
    /**
     * @param array $userIDs
     */
    public function deleteUserIds($userIDs)
    {
        foreach ($userIDs as $userID) {
            $this->deleteUserId($userID);
        }
    }
    public function getDeletedUserId()
    {
        if (count($this->usersInfo) === 0) {
            echo 'No user info.';
            die;
        } else {
            foreach ($this->usersInfo as $key => $val) {
                if (isset($val['del']) == 0) {
                    continue;
                }
                $userIdList[] = $key;
            }
        }
        return $userIdList;
    }
    public function checkUserRemine($userId, $remineName = null)
    {
        if ($remineName) {
            if (isset($this->usersInfo[$userId]['remine'][$remineName])) {
                return [$remineName => $this->usersInfo[$userId]['remine'][$remineName]];
            }
        } else {
            if (isset($this->usersInfo[$userId]['remine'])) {
                return $this->usersInfo[$userId]['remine'];
            }
        }
        return false;
    }
    private function setUserRemine($userId, $remineName)
    {
        if (isset($this->usersInfo[$userId])) {
            $this->usersInfo[$userId]['remine'][$remineName] = true;
            file_put_contents(USER_DB_PATH, json_encode($this->usersInfo, JSON_FORCE_OBJECT));
            return true;
        } else {
            return false;
        }
    }
    private function delUserRemine($userId, $remineName)
    {
        if (isset($this->usersInfo[$userId])) {
            $this->usersInfo[$userId]['remine'][$remineName] = false;
            file_put_contents(USER_DB_PATH, json_encode($this->usersInfo, JSON_FORCE_OBJECT));
            return true;
        } else {
            return false;
        }
    }
    public function setEarthquakeRemine($userId)
    {
        return $this->setUserRemine($userId, 'earthquake');
    }
    public function delEarthquakeRemine($userId)
    {
        return $this->delUserRemine($userId, 'earthquake');
    }
    public function setStockRemine($userId)
    {
        return $this->setUserRemine($userId, 'stock');
    }
    public function delStockRemine($userId)
    {
        return $this->delUserRemine($userId, 'stock');
    }
}
