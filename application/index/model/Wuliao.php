<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Wuliao extends Model{
	function store($data){
		$rule = [
		    'zu_id'			=> 'must|number',
		    'wuliao_name'	=> 'must|max:50',
		    'danw_zu_id'	=> 'must|number',
		    'user_id'		=> 'must|number'
		];

		$msg = [
		    'zu_id.must'			=> '物料组不得为空',
		    'zu_id.number'			=> '物料组ID必须为数字',
		    'wuliao_name.must'		=> '物料名称不得为空',
		    'wuliao_name.max'		=> '物料名称不得超过50个字符',
		    'danw_zu_id.must'		=> '单位组不得为空',
		    'danw_zu_id.number'		=> '单位组ID必须为数字',
		    'user_id.must'			=> '用户ID不得为空',
		    'user_id.number'		=> '用户ID必须为数字'
		];


		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);


		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{
			$wuliao=new Wuliao;
			if($data['id']>0){
				$wuliao->isUpdate(true)->save($data);
			}else{
				if($wuliao->save($data)>0){
					return $wuliao->id;
				}
			}
		}
	}


	function checkunique($item, $zhangtid = 0){
		$row = Wuliao::where('wuliao_name','=',$item)
			->where('zhangt_id','=',($zhangtid>0)?$zhangtid:session('zhangtao_id'))
			->count();
		return $row;
	}
}