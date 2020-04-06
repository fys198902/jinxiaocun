<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Danw extends Model{
	function store($data){
		$rule = [
		    'danw_zu'		=> 'must|max:10',
		    'user_id'		=> 'must|number',
		    'zhangt_id'		=> 'must|number'
		];

		$msg = [
		    'danw_zu.must'		=> '单位组不得为空',
		    'danw_zu.max'		=> '单位组名不得超过10个字符',
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
			$danw=new Danw;
			if($data['id']>0){
				$danw->isUpdate(true)->save($data);
			}else{
				if($danw->save($data)>0){
					return $danw->id;
				}
			}
		}
	}
}