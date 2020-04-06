<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Zhangtao extends Model{
	function store($data){
		$rule = [
		    'zhangtao'		=> 'must',
		    'zhangtao'		=> 'unique:zhangtao'
		];

		$msg = [
		    'zhangtao.must'		=> '账套名称不得为空',
		    'zhangtao.unique'	=> '此账套已存在'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$zhangtao = new Zhangtao;
			if($zhangtao->save($data)>0){
				return $zhangtao->id;
			}
		}
	}
}