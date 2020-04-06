<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Wuliaozu extends Model{
	function store($data){
		$rule = [
		    'wuliao_zu'		=> 'must|max:20',
		    'user_id'		=> 'must|number',
		    'zhangt_id'		=> 'must|number'
		];

		$msg = [
		    'wuliao_zu.must'	=> '物料组名不得为空',
		    'wuliao_zu.max'		=> '物料组名不得超过20个字符',
		    'user_id.must'		=> '用户ID不得为空',
		    'user_id.number'	=> '用户ID必须为整数',
		    'zhangt_id.must'	=> '账套ID不得为空',
		    'zhangt_id.number'	=> '账套ID必须为数字'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$Wuliaozu=new Wuliaozu;
			if($data['id']>0){
				$Wuliaozu->isUpdate(true)->save($data);
			}else{
				if($Wuliaozu->save($data)>0){
					return $Wuliaozu->id;
				}
			}
		}
	}
}