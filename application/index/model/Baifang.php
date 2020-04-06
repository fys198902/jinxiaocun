<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Baifang extends Model{
	function store($data){
		$rule = [

		];

		$msg = [

		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$baifang=new Baifang;
			if($data['id']>0){
				$baifang->isUpdate(true)->save($data);
			}else{
				if($baifang->save($data)>0){
					return $baifang->id;
				}
			}
		}
	}
}