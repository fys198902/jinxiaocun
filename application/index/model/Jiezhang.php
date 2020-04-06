<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Jiezhang extends Model{
	function store($data){
		$rule = [
		    'fyear'			=> 'must|number',
		    'fmonth'		=> 'must|number',
		    'user_id'		=> 'must|number',
		    'zhangt_id'		=> 'must|number'
		];

		$msg = [
		    'fyear.must'		=> '年 不得为空',
		    'fyear.number'		=> '年 必须为数字',
		    'fmonth.must'		=> '月 不得为空',
		    'fmonth.number'		=> '月 必须为数字',
		    'user_id.must'		=> '用户ID不得为空',
		    'user_id.number'	=> '用户ID必须为数字',
		    'zhangt_id.must'	=> '账套ID不得为空',
		    'zhangt_id.number'	=> '账套ID必须为数字'

		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$jiezhang=new jiezhang;
			if($jiezhang->save($data)>0){
				return $jiezhang->id;
			}
		}
	}
}