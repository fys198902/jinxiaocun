<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Cangku extends Model{
	function store($data){
		$rule = [
		    'cangk_name'		=> 'must|max:20',
		    'cangk_dizhi'		=> 'max:100',
		    'cangk_lianxfs'		=> 'max:50',
		    'user_id'			=> 'must|number',
		    'zhangt_id'			=> 'must|number'
		];

		$msg = [
		    'cangk_name.must'		=> '仓库名称不得为空',
		    'cangk_name.max'		=> '仓库名称不得超过20个字符',
		    'cangk_dizhi.max'		=> '仓库地址不得超过100个字符',
		    'cangk_lianxfs'			=> '仓库联系方式不得超过50个字符',
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
			$cangku=new Cangku;
			if($data['id']>0){
				$cangku->isUpdate(true)->save($data);
			}else{
				if($cangku->save($data)>0){
					return $cangku->id;
				}
			}
		}
	}

	function checkunique($item){
		$row = Cangku::where('cangk_name','=',$item)
			->where('zhangt_id','=',session('zhangtao_id'))
			->count();
		return $row;
	}
}