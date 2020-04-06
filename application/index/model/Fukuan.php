<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Fukuan extends Model{
	function store($data){
		$rule = [
			'fukuan_xt_id'	=> 'must|max:13',
			'fdate'			=> 'date',
		    'gongys_id'		=> 'must|number',
		    'zhaiyao'		=> 'must',
		    'shifu'			=> 'regex:/^[0-9]+(.[0-9]{1,100})?$/',
		    'zhekou'		=> 'regex:/^-?[0-9]+(.[0-9]{1,100})?$/',
		    'shoukleibie_id'=> 'must|number|gt:0',
		    'user_id'		=> 'must',
		    'zhangt_id' 	=> 'must'
		];

		$msg = [
			'fukuan_xt_id.must'		=> '付款单据编号不得为空',
			'fukuan_xt_id.max'		=> '付款单据编号不得超过13个字符',
		    'gongys_id.must'		=> '供应商ID不得为空',
		    'gongys_id.number'		=> '供应商ID必须为整数',
		    'gongys_id.number'		=> '供应商ID必须为整数',
		    'zhaiyao.must'			=> '摘要不得为空',
		    'shoukleibie_id.must'	=> '收付类别ID不得为空',
		    'shoukleibie_id.number'	=> '收付类别ID必须为数字',
		    'shoukleibie_id.gt'		=> '收付类别ID必须大于0',
		    'shifu.regex'			=> '实付金额必须为数字且不得为负数',
		    'zhekou.regex'			=> '折扣必须为有效数字',
		    'user_id.must'			=> '用户ID不得为空',
		    'zhangt_id.must'		=> '账套ID不得为空'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$fukuan=new Fukuan;
			if($data['id']>0){
				$fukuan->isUpdate(true)->save($data);
			}else{
				if($fukuan->save($data)>0){
					return $fukuan->id;
				}
			}
		}
	}
}