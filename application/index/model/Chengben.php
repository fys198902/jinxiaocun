<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Chengben extends Model{
	function store($data){
		$rule = [
		    'jiezhang_id'		=> 'must|number',
		    'wuliaoid'			=> 'must|number',
		    'shul'				=> 'must|number',
		    'jine'				=> 'must|regex:/^-?[0-9]+(.[0-9]{1,100})?$/'
		];

		$msg = [
		    'jiezhang_id.must'		=> '结账ID不得为空',
		    'jiezhang_id.number'	=> '结账ID必须为整数',
		    'wuliaoid.must'			=> '物料ID不得为空',
		    'wuliaoid.number'		=> '物料ID必须为整数',
		    'shul.must'				=> '数量不得为空',
		    'shul.number'			=> '数量必须为整数',
		    'jine.must'				=> '金额不得为空',
		    'jine.regex'			=> '金额必须为数字，请检查'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$chengben=new chengben;
			if($chengben->save($data)>0){
				return $chengben->id;
			}
		}
	}
}