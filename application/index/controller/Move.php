<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;

class Move extends Controller{
	public function bindweixin(){
		$username = input('username');
		$password = input('password');
		$openid = input('openid');
		
		$weixininfo = Db::table('weixin')->where('weixinid',$openid)->find();
		if($weixininfo != null){
			$userid = $weixininfo['user_id'];
			$arr = Db::table('user')->where('id',$userid)->find();
			$zhangtid = $arr['zhangt_id'];
			$data['status'] = 1;
			$data['msg'] = 'ok';
			$data['zhangtid'] = $zhangtid;
			$data['userid'] = $userid;
			$data['username'] = $arr['username'];
			return json($data);
		}else{
			if($username != '' && $password != '' && input('openid') != ''){
				$row = Db::table('user')
					->where('username',$username)
					->find();
				if($row['password'] == md5($password)){
					session('username', $username);
					session('zhangtao_id', $row['zhangt_id']);
					$fdata['user_id'] = $row['id'];
					$fdata['weixinid'] = $openid;
					if(Db::table('weixin')->where('user_id',$row['id'])->value('weixinid') == null){
						if(Db::name('weixin')->insert($fdata)){
							$data['status'] = 4;
							$data['msg'] = '绑定成功';
							$data['zhangtid'] = $row['zhangt_id'];
							$data['userid'] = $row['id'];
							$data['username'] = $row['username'];
							return json($data);
						}
					}				
				}else{
					$data['status'] = 3;
					$data['msg'] = '用户名或密码错误';
					return json($data);
				}
			}else{
				$data['status'] = 2;
				$data['msg'] = '用户名密码或code不得为空';
				return json($data);
			}
		}
	}


	public function getopenid(){
		$code = input('code');
        $appid = 'wx1626bb98bf61dd17'; // 小程序APPID
        $secret = '3c9279e528ed685b3dc0331d4373e495'; // 小程序secret
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';  
 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);    
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        
        return $res;
    }

    public function jishi(){

        $row = Db::table('taizhang')
            ->where('zhangt_id','=', input('zhangtaoid'))
            ->field('wuliaoid,wuliao_name,cangk_id,cangk_name,sum(shul) as jiben')
            ->group('wuliaoid,wuliao_name,cangk_id,cangk_name')
            ->select();
    	
        // return json($row);
        return json($row);
    	
    }

    public function uploadfile(){
    	$file = request()->file('image');
	    // 移动到框架应用根目录/uploads/ 目录下
	    $info = $file->move( 'public/uploads');
	    if($info){
	        echo $info->getSaveName();
	    }else{
	        echo $file->getError();
	    }
    }

    public function baifang_insert(){
    	$upload_lujing = input('lujing');
    	$neirong = input('neirong');
    	$zhongduan_id = input('id');
    	$userid = input('userid');

    	$fdata['id'] = 0;
    	$fdata['fdate'] = date('Y-m-d H:i:s');
    	$fdata['zhongd_id'] = $zhongduan_id;
    	$fdata['neirong'] = $neirong;
    	$fdata['user_id'] = $userid;

    	Db::startTrans();
        try {
	    	$baifang = model('baifang');
	    	$baifangid = $baifang->store($fdata);
	    	if($baifangid>0){
	    		$baifangentry = model('baifangentry');
	    		$fdata1['id'] = 0;
	    		$fdata1['baifang_id'] = $baifangid;
	    		for($i=0; $i< count($upload_lujing); $i++){
	    			$fdata1['uploadfile'] = $upload_lujing[$i];
	    			if(!$baifangentry->store($fdata1)){
	    				throw new \Exception('拜访记录明细添加失败');
	    			}
	    		}
	    	}else{
	    		throw new \Exception('拜访记录主体添加失败');
	    	}
    		Db::commit();
        	return json('保存成功');
        } catch (\Exception $e) {
            Db::rollback();
            return json($e->getMessage());
        }

    }

    public function baifang_list(){
    	$zhongd_id = input('zhangd_id');
    	$row = Db::table('baifang')
    		->where('user_id','=', input('userid'))
    		->where('zhongd_id',input('zhongd_id'))
    		->order('fdate desc')
            ->limit(5)
    		->select();
    	return json($row);
    }

    
    public function getkehu(){
        $kehuval = input('kehu');
    	$row = Db::table('kehu')
            ->where('kehu_name','like',"%$kehuval%")
            ->where('zhangt_id','=', input('zhangt_id'))
            ->select();
        return json($row);
    }

}
