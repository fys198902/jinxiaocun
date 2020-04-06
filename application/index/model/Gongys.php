<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Gongys extends Model{
	function store($data){
		$rule = [
		    'gongys_name'		=> 'must|max:50',
		    'gongys_dizhi'		=> 'must|max:100',
		    'gongys_lianxr'		=> 'max:10',
		    'gongys_lianxfs'	=> 'max:50',
		    'user_id'			=> 'must|number',
		    'zhangt_id'			=> 'must'

		];

		$msg = [
		    'gongys_name.must'		=> '供应商名称不得为空',
		    'gongys_name.max'		=> '供应商名称不得超过50个字符',
		    'gongys_dizhi.must'		=> '供应商地址不得为空',
		    'gongys_dizhi.max'		=> '供应商地址不得超过100个字符',
		    'gongys_lianxr.max'		=> '供应商联系人不得超过10个字符',
		    'gongys_lianxfs.max'	=> '供应商联系方式不得超过50个字符',
		    'user_id.must'			=> '用户ID不得为空',
		    'user_id.number'		=> '用户ID必须为数字',
		    'zhangt_id.must'		=> '账套ID不得为空'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$gongys=new Gongys;
			if($data['id']>0){
				$gongys->isUpdate(true)->save($data);
			}else{
				if($gongys->save($data)>0){
					return $gongys->id;
				}
			}
		}
	}


	function checkunique($item){
		$row = Gongys::where('gongys_name','=',$item)
			->where('zhangt_id','=',session('zhangtao_id'))
			->count();
		return $row;
	}
}