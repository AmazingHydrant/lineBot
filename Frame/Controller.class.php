<?php
class Controller
{
    protected $userM;
    protected $to;
    protected $push_M;
    public function __construct()
    {
        $this->initModel();
    }
    protected function initModel()
    {
        $this->userM = new UserModel;
        $this->to = $this->userM->getUserIdList();
        $this->push_M = new PushModel;
    }
    protected function display($view)
    {
        require V_DIR . CONTROLLER . "/{$view}";
    }
}
