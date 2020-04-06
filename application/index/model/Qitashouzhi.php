<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Qitashouzhi extends Model{
	function store($data){
		$rule = [
		    'shouz_xt_id'		=> 'must|max:13',
		    'fdate'				=> 'must|date',
		    'zhaiyao'			=> 'must',
		    'leibie'			=> 'must|number',
		    'jine'				=> 'must|regex:/^[0-9]+(.[0-9]{1,100})?$/',
		    'shoukleibie_id'	=> 'must|number|gt:0',
		    'user_id'			=> 'must|number',
		    'zhangt_id'			=> 'must|number'
		];

		$msg = [
		    'shouz_xt_id.must'			=> '单据ID不得为空',
		    'shouz_xt_id.max'			=> '单据ID不得超过13个字符',
		    'fdate.must'				=> '日期不得为空',
		    'fdate.date'				=> '日期格式有误，请重新输入',
		    'zhaiyao.must'				=> '摘要不得为空',
		    'leibie.must'				=> '类别不得为空',
		    'leibie.number'				=> '类别必须为整数',
		    'shoukleibie_id.must'		=> '收款类别ID不得为空',
		    'shoukleibie_id.number'		=> '收款类别ID必须为数字',
		    'shoukleibie_id.gt'			=> '收款类别ID必须大于0',
		    'jine.must'					=> '金额不得为空',
		    'jine.regex'				=> '金额必须为数字且不得为负数，请检查',
		    'user_id.must'				=> '用户ID不得为空',
		    'user_id.number'			=> '用户ID必须为数字',
		    'zhangt_id.must'			=> '账套ID不得为空',
		    'zhangt_id.number'			=> '账套ID必须为数字'

		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$qitashouzhi=new Qitashouzhi;
			if($data['id']>0){
				$qitashouzhi->isUpdate(true)->save($data);
			}else{
				if($qitashouzhi->save($data)>0){
					return $qitashouzhi->id;
				}
			}
		}
	}
}