<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Shoukuan extends Model{
	function store($data){
		$rule = [
			'shouk_xt_id'	=> 'must|max:13',
			'fdate'			=> 'must|date',
		    'kehu_id'		=> 'must|number',
		    'zhaiyao'		=> 'must',
		    'shoukleibie_id'=> 'must|number|gt:0',
		    'shishou'		=> 'regex:/^[0-9]+(.[0-9]{1,100})?$/',
		    'zhekou'		=> 'regex:/^-?[0-9]+(.[0-9]{1,100})?$/',
		    'user_id'		=> 'must|number',
		    'zhangt_id'		=> 'must|number'
		];

		$msg = [
			'shouk_xt_id.must'		=> '收款单据ID不得为空',
			'shouk_xt_id.max'		=> '收款单据ID不得超过13个字符',
			'fdate.must'			=> '日期不得为空',
			'fdate.date'			=> '日期格式不对，请重新输入',
		    'kehu_id.must'			=> '客户不得为空',
		    'kehu_id.number'		=> '客户ID必须为数字',
		    'zhaiyao.must'			=> '摘要不得为空',
		    'shoukleibie_id.must'	=> '收款类别ID不得为空',
		    'shoukleibie_id.number'	=> '收款类别ID必须为整数',
		    'shoukleibie_id.gt'		=> '收款类别ID必须大于0',
		    'shishou.regex'			=> '实收金额必须为数字且不得为负数',
		    'zhekou.regex'			=> '折扣金额必须为数字',
		    'user_id.must'			=> '用户ID不得为空',
		    'user_id.number'		=> '用户ID必须为整数',
		    'zhangt_id.must'		=> '账套ID不得为空',
		    'zhangt_id.number'		=> '账套ID必须为整数'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$shoukuan=new Shoukuan;
			if($data['id']>0){
				$shoukuan->isUpdate(true)->save($data);
			}else{
				if($shoukuan->save($data)>0){
					return $shoukuan->id;
				}
			}
		}
	}
}