<?php
class UserModel
{
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
    }
    public function getUserIdList()
    {
        $usersID = json_decode(file_get_contents(USER_DB_PATH), true);
        if (count($usersID) === 0) {
            echo 'No user info.';
            die;
        } else {
            foreach ($usersID as $key => $val) {
                if (isset($val['del']) == 1) {
                    continue;
                }
                $userIdList[] = $key;
            }
        }
        return $userIdList;
    }
    /**
     * @param string $userID
     */
    public function addUserId($userID)
    {
        $userInfo = json_decode(file_get_contents(USER_DB_PATH), true);
        $userInfo[$userID] = [];
        file_put_contents(USER_DB_PATH, json_encode($userInfo, JSON_FORCE_OBJECT));
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
    public function deleteUserId($userID)
    {
        $userInfo = json_decode(file_get_contents(USER_DB_PATH), true);
        if (!isset($userInfo[$userID])) {
            echo "{$userID} 不存在";
            return false;
        }
        $userInfo[$userID] = ['del' => '1'];
        file_put_contents(USER_DB_PATH, json_encode($userInfo, JSON_FORCE_OBJECT));
    }
    public function deleteUserIds($userIDs)
    {
        foreach ($userIDs as $userID) {
            $this->deleteUserId($userID);
        }
    }
    public function getDeletedUserId()
    {
        $usersID = json_decode(file_get_contents(USER_DB_PATH), true);
        if (count($usersID) === 0) {
            echo 'No user info.';
            die;
        } else {
            foreach ($usersID as $key => $val) {
                if (isset($val['del']) == 0) {
                    continue;
                }
                $userIdList[] = $key;
            }
        }
        return $userIdList;
    }
}
