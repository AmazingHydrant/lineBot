<?php
class AdminModel
{
    /**
     * @var PDODB $pdodb
     */
    protected $pdodb;
    /**
     * init PDODB
     */
    public function __construct()
    {
        $this->initPDODB();
    }
    /**
     * init params new PDODB
     */
    private function initPDODB()
    {
        $option = [
            'pass' => '!@#123qwe',
            'dbname' => 'linebot'
        ];
        $this->pdodb = PDODB::getInstance($option);
    }
    /**
     * check username & password
     * @param string $user
     * @param string $pass
     */
    public function check($user, $pass)
    {
        $res = $this->pdodb->myQuery("select user from users where user = ? and pass = ?", [$user, md5($pass)]);
        return $res;
    }
}
