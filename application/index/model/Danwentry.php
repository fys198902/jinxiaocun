<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Danwentry extends Model{
	function store($data){
		$rule = [
			'danw_zu_id'	=> 'must|number',
		    'danw_name'		=> 'must|max:10',
		    'danw_huans'	=> 'must|number'
		];

		$msg = [
		    'danw_zu_id.must'		=> '单位组ID不得为空',
		    'danw_zu_id.number'		=> '单位组ID必须为整数',
		    'danw_name.must'		=> '单位名不得为空',
		    'danw_name.max'			=> '单位名不得超过10个字符',
		    'danw_huans.must'		=> '换算率不得为空',
		    'danw_huans.number'		=> '换算率必须为整数'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);

		$danwentry=new danwentry;
		if(!$result) {
		    dump($validate->getError());
		}else{
			$danwentry=new danwentry;
			if($data['id']>0){
				$danwentry->isUpdate(true)->save($data);
			}else{
				if($danwentry->save($data)>0){
					return $danwentry->id;
				}
			}
		}
	}
}