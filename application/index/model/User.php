<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class User extends Model{
	function store($data){
		$rule = [
		    'username'		=> 'must|max:50|unique:user',
		    'password'		=> 'must|max:32',
		    'closingdate'	=> 'must|date',
		    'zhangt_id'		=> 'must|number'

		];

		$msg = [
		    'username.must'		=> '用户名称不得为空',
		    'username.max'		=> '用户名称不得超过50个字符',
		    'username.unique'	=> '用户名重复，请更换	',
		    'password.must'		=> '密码不得为空',
		    'password.max'		=> '密码不得超过32个字符',
		    'closingdate.must'	=> '截止日期必填',
		    'closingdate.date'	=> '截止日期必须为日期格式',
		    'zhangt_id.must'	=> '账套ID必填',
		    'zhangt_id.number'	=> '账套ID必须为整数'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$user=new User;
			if($data['id']>0){
				$user->isUpdate(true)->save($data);
			}else{
				if($user->save($data)>0){
					return $user->id;
				}
			}
		}
	}
}