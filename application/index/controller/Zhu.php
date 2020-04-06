<?php
namespace app\index\controller;
use think\Db;
use think\facade\Session;


class Zhu extends Common{
	public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
		    $this->_initialize();
		}
    }


    public function zhu(){
    	return view('Zhu/zhu');
    }

}
