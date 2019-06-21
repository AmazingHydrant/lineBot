<?php
class AdminController extends Controller
{
    /**
     * login page
     */
    public function login()
    {
        $this->display('login.php');
    }
    /**
     * check username & password
     */
    public function check()
    {
        $adminM = new AdminModel;
        if ($adminM->check($_POST['user'], $_POST['pass'])) {
            header('Location: ' . "{$_SERVER['PHP_SELF']}?p=admin&c=Manager&a=index");
        } else {
            echo "no";
        }
    }
}
