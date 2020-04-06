<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Caigou extends Model{
	function store($data){
		$rule = [
		    'caig_xt_id'		=> 'must|max:15',
		    'caig_date'			=> 'must|date',
		    'gongys_id'			=> 'must|number',
		    'caig_zhaiy'		=> 'max:255',
		    'caig_cangk_id'		=> 'must|number',
		    'user_id'			=> 'must|number',
		    'zhangt_id'			=> 'must|number'
		];

		$msg = [
		    'caig_xt_id.must'		=> '采购单据ID不得为空',
		    'caig_xt_id.max'		=> '采购单据ID不得超过15个字符',
		    'caig_date.must'		=> '采购日期不得为空',
		    'caig_date.date'		=> '采购日期不规范，请重填',
		    'gongys_id.must'		=> '供应商不得为空',
		    'gongys_id.number'		=> '供应商ID必须为数字',
		    'caig_zhaiy.max'		=> '采购摘要不得超过255个字符',
		    'caig_cangk_id.must'	=> '仓库ID不得为空',
		    'caig_cangk_id.number'	=> '仓库ID必须为数字',
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
			$caigou=new Caigou;
			if($data['id']>0){
				$caigou->isUpdate(true)->save($data);
			}else{
				if($caigou->isUpdate(false)->save($data)>0){
					return $caigou->id;
				}
			}
		}
	}
}