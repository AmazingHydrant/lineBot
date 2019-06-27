<?php
class ManagerController extends Controller
{
    /**
     * manager indxe page
     */
    public function index()
    {
        $stockM = new StockModel;
        self::$var['info'] = $stockM->getStockInfo();
        $this->display('index.php');
    }
}
