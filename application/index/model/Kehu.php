<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Kehu extends Model{
	function store($data){
		$rule = [
		    'kehu_name'		=> 'must|max:50',
		    'kehu_dizhi'	=> 'must|max:100',
		    'kehu_lianxr'	=> 'max:10',
		    'kehu_lianxfs'	=> 'max:50',
		    'user_id'		=> 'must|number',
		    'zhangt_id'		=> 'must|number'

		];

		$msg = [
		    'kehu_name.must'		=> '客户名称不得为空',
			'kehu_name.max'			=> '客户名称不得超过50个字符',
		    'kehu_dizhi.must'		=> '客户地址不得为空',
		    'kehu_dizhi.max'		=> '客户地址不得超过100个字符',
		    'kehu_lianxr.max'		=> '客户联系人不得超过10个字符',
		    'kehu_lianxfs.max'		=> '客户联系方式不得超过50个字符',
		    'user_id.must'			=> '用户ID不得为空',
		    'user_id.number'		=> '用户ID必须为数字',
		    'zhangt_id.must'		=> '账套ID不得为空',
		    'zhangt_id.number'		=> '账套ID必须为数字'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$kehu=new Kehu;
			if($data['id']>0){
				$kehu->isUpdate(true)->save($data);
			}else{
				if($kehu->save($data)>0){
					return $kehu->id;
				}
			}
		}
	}

	function checkunique($item){
		$row = Kehu::where('kehu_name','=',$item)
			->where('zhangt_id','=',session('zhangtao_id'))
			->count();
		return $row;
	}
}