<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Baifangentry extends Model{
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
			$baifangentry=new Baifangentry;
			if($data['id']>0){
				$baifangentry->isUpdate(true)->save($data);
			}else{
				if($baifangentry->save($data)>0){
					return $baifangentry->id;
				}
			}
		}
	}
}