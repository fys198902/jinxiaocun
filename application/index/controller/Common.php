<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;

class Common extends Controller{
	public function _initialize(){
		$check = 0;
		if(input('?openid') && input('?userid')){
			$check = Db::table('weixin_user')
				->where('user_id', input('userid'))
				->where('weixinid', input('openid'))
				->count();
		}

		if($check == 0){
			if(!Session::has('username') || !Session::has('zhangtao_id')){
				$this->redirect('/');
			}

			if(session('shengyutianshu') < 0){
				echo '<span class="label label-danger">软件已到期，请联系管理员：微信18113220863</span>';
				exit();
			}
		}else{
			$lastdate = Db::table('user')
				->where('id', input('userid'))
				->value('closingdate');
			if($lastdate < date('Y-m-d')){
				echo '<span class="label label-danger">软件已到期，请联系管理员：微信18113220863</span>';
				exit();
			}
		}


	}

	public function checkquanxian(){
		// $juese_id = Db::table('userjuese')
		// 	->where('user_id','=',session('userid'))
		// 	->column('jues_id');

		// $quanx_id = Db::table('juesequanxian')
		// 	->where('jues_id','in', $juese_id)
		// 	->column('quanx_id');

		// $quanxian = Db::table('quanxian')
		// 	->where('id','in', $quanx_id)
		// 	->field('concat(model,"/",controller,"/",action) as quanxian')
		// 	->select();

		// $row = [];
		// for($i=0; $i < count($quanxian); $i++){
		// 	array_push($row, $quanxian[$i]['quanxian']);
		// }


		// if(in_array(strtolower(str_replace('.html','',Request()->pathinfo())) , $row)){
		// 	return true;
		// }else{
		// 	echo '抱歉，您没有权限！';
		// 	exit();
		// }

		return true;

	}
}
