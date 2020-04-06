<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;


class Hetong extends Common{
    public function hetong_insert(){
    	return view('Hetong/');
    }


}
