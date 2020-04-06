<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Shoukuanleibie extends Model{
	function store($data){
		$rule = [
			'shoukleibie'	=> 'must|max:50',
		    'user_id'		=> 'must|number',
		    'zhangt_id'		=> 'must|number'
		];

		$msg = [
			'shoukleibie.must'		=> '收款类别不得为空',
			'shoukleibie.max'		=> '收款类别不得超过50个字符',
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
			$shoukuanleibie=new Shoukuanleibie;
			if($data['id']>0){
				$shoukuanleibie->isUpdate(true)->save($data);
			}else{
				if($shoukuanleibie->save($data)>0){
					return $shoukuanleibie->id;
				}
			}
		}
	}

	function checkunique($item, $zhangtid=0){
		$row = Shoukuanleibie::where('shoukleibie','=',$item)
			->where('zhangt_id','=',($zhangtid>0)?$zhangtid:session('zhangtao_id'))
			->count();
		return $row;
	}
}