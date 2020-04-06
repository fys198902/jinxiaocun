<?php
namespace app\index\model;
use think\Model;
use think\Validate;

class Xiaoshou extends Model{
	function store($data){
		$rule = [
		    'xiaos_xt_id'		=> 'must|max:15',
		    'xiaos_date'		=> 'must|date',
		    'kehu_id'			=> 'must|number',
		    'xiaos_zhaiy'		=> 'max:255',
		    'xiaos_cangk_id'	=> 'must|number',
		    'yuang_id'			=> 'number',
		    'user_id'			=> 'must|number',
		    'zhangt_id'			=> 'must|number'
		];

		$msg = [
		    'xiaos_xt_id.must'			=> '销售单据ID不得为空',
		    'xiaos_xt_id.max'			=> '销售单据ID不得超过15个字符',
		    'xiaos_date.must'			=> '销售日期不得为空',
		    'xiaos_date.date'			=> '销售日期不规范，请重填',
		    'kehu_id.must'				=> '供应商不得为空',
		    'kehu_id.number'			=> '供应商ID必须为数字',
		    'xiaos_cangk_id.must'		=> '仓库不得为空',
		    'xiaos_cangk_id.number'		=> '仓库ID必须为数字',
		    'yuang_id.number'			=> '经手人ID必须为数字',
		    'xiaos_zhaiy.max'			=> '采购摘要不得超过255个字符',
		    'user_id.must'				=> '用户ID不得为空',
		    'user_id.number'			=> '用户ID必须为数字',
		    'zhangt_id.must'			=> '账套ID不得为空',
		    'zhangt_id.number'			=> '账套ID必须为数字'
		];


		
		$validate   = Validate::make($rule,$msg);
		$result = $validate->check($data);

				
		if(!$result) {
		    dump($validate->getError());
		    exit();
		}else{

			$xiaoshou=new Xiaoshou;
			if($data['id']>0){
				$xiaoshou->isUpdate(true)->save($data);
			}else{

				if($xiaoshou->save($data)>0){
					return $xiaoshou->id;
				}
			}
		}
	}
}