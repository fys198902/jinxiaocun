<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Userjuese extends Model{
	function store($data){
		$rule = [
		    'user_id'		=> 'must|number',
		    'jues_id'		=> 'must|number',
		];

		$msg = [
		    'user_id.must'		=> '用户ID不得为空',
		    'user_id.number'	=> '用户ID必须为整数',
		    'jues_id.must'		=> '角色ID不得为空',
		    'jues_id.number'	=> '角色ID必须为整数'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$userjuese=new Userjuese;
			if($data['id']>0){
				$userjuese->isUpdate(true)->save($data);
			}else{
				if($userjuese->save($data)>0){
					return $userjuese->id;
				}
			}
		}
	}
}