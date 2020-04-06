<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Yuangong extends Model{
	function store($data){
		$rule = [
		    'yuang'			=> 'must|max:20',
		    'lianxfs'		=> 'must|max:50',
		    'user_id'		=> 'must|number',
		    'zhangt_id'		=> 'must|number'

		];

		$msg = [
		    'yuang.must'		=> '员工姓名不得为空',
		    'yuang.max'			=> '员工姓名不得超过20个字符',
		    'lianxfs.must'		=> '员工联系方式不得为空',
		    'lianxfs.max'		=> '员工联系方式不得超过50个字符',
		    'user_id.must'		=> '用户ID不得为空',
		    'user_id.number'	=> '用户ID必须为整数',
		    'zhangt_id.must'	=> '账套ID不得为空',
		    'zhangt_id.number'	=> '账套ID必须为整数'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$yuangong=new Yuangong;
			if($data['id']>0){
				$yuangong->isUpdate(true)->save($data);
			}else{
				if($yuangong->save($data)>0){
					return $yuangong->id;
				}
			}
		}
	}
}