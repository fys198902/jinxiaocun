<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Xiaoshouentry extends Model{
	function store($data){
		$rule = [
		    'xiaos_id'	=> 'must|number',
		    'wuliao_id'	=> 'must|number',
		    'danw_id'	=> 'must|number',
		    'shul'		=> 'must|integer',
		    'danj'		=> 'regex:/^-?[0-9]+(.[0-9]{1,100})?$/',
		    'jine'		=> 'regex:/^-?[0-9]+(.[0-9]{1,100})?$/',
		    'beizhu'	=> 'max:255'
		];

		$msg = [
		    'xiaos_id.must'			=> '主体ID不得为空',
		    'xiaos_id.number'		=> '销售ID必须为整数',
		    'wuliao_id.must'		=> '物料ID不得为空',
		    'wuliao_id.number'		=> '物料ID必须为整数',
		    'danw_id.must'			=> '物料ID不得为空',
		    'danw_id.number'		=> '单位ID必须为整数',
		    'shul.must'				=> '数量不得为空',
		    'shul.integer'			=> '数量ID必须为整数',
		    'danj.regex'			=> '单价ID必须为数字',
		    'jine.regex'			=> '金额ID必须为数字',
		    'beizhu.max'			=> '备注字符串不得超过255个',
		];

		$validate = Validate::make($rule,$msg);
		$result = $validate->check($data);

		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$xiaoshouentry=new xiaoshouentry;
			if($xiaoshouentry->save($data)>0){
				return $xiaoshouentry->id;
			}
		}
	}
}