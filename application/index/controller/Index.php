<?php
namespace app\index\controller;
use think\Db;
use think\Validate;
use think\Controller;
use think\facade\Session;
use think\captcha\Captcha;


class Index extends Controller{
    public function index(){
    	return $this->fetch('Index/index');
    }

    public function checklogin(){
    	if(Session::has('username') && Session::has('zhangtao_id')){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function verify()
    {
    	$config =    [
		    // 验证码字体大小
		    'fontSize'    =>    20,
		    // 验证码高度
		    'imageH'	  =>    36,
		    //验证码宽度
		    'imageW'	  =>    185, 
		    // 验证码位数
		    'length'      =>    4,   
		    // 关闭验证码杂点
		    'useNoise'    =>    false, 
		    //是否启用混淆曲线
		    'useCurve'	  =>	false,
		    //设定字体
		    'fontttf'	  =>    '2.ttf'
		];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }


    public function login(){
    	$username=input('post.fuser');
    	$password=input('post.fpwd');
    	$yanzm=input('post.fyanzm');
    	$captcha = new Captcha();
    	if(!$captcha->check($yanzm)){
			return json('验证错误，请重新输入');
		}else{
			$rule = [
			    'username'  => 'must|max:50',
			    'password' 	=> 'must'
			];

			$msg = [
			    'username.must' 	=> '用户名称必填',
			    'username.max'     	=> '用户名不得超过50个字符',
			    'password.must'   	=> '密码必填',
			];

			$data = [
			    'username'  => $username,
			    'password' =>  $password
			];


			$validate = Validate::make($rule,$msg);
			if (!$validate->check($data)) {
			    dump($validate->getError());
			}else{
				$userinfo = Db::table('user')
					->where('username','=',$username)
					->find();
				if($userinfo != null){
					if($userinfo['password'] == md5($password)){
						$zhangtao = Db::table('zhangtao')->where('id','=', $userinfo['zhangt_id'])->value('zhangtao');
						Db::name('user')->where('id',$userinfo['id'])->setField('lastlogintime', date('Y-m-d H:i:s'));
						Session::set('username',$username);
						Session::set('userid',$userinfo['id']);
						Session::set('zhangtao_id', $userinfo['zhangt_id']);
						Session::set('zhangtao_name',$zhangtao);
						Session::set('closingdate', $userinfo['closingdate']);
						Session::set('shengyutianshu', (strtotime(session('closingdate'))-strtotime(date('Y-m-d')))/3600/24);
						return true;
					}else{
						return json('用户名或密码错误');
					}
				}else{
					return json('用户名或密码错误');
				}
				
			}
		}
    }


    public function logout(){
    	Session::delete('username');
    	Session::delete('zhangtao_id');
    	session(null);
    	$this->redirect('/');
    }

    public function zhu(){
    	return view('Index/zhu');
    }

    public function zhuce(){
    	return view('Index/zhuce');
    }

    public function zhuce_do(){
    	$captcha = new Captcha();
    	if(!$captcha->check(input('post.yanzm'))){
			return json('验证错误，请重新输入');
		}

    	$rule = [
		    'username'  	=> 'must|max:50',
		    'password' 		=> 'must',
		    'repassword'	=> 'must|confirm:password',
		    'gongs'			=> 'must|max:50'
		];

		$msg = [
		    'username.must' 	=> '用户名称必填',
		    'username.max'     	=> '用户名不得超过50个字符',
		    'password.must'   	=> '密码必填',
		    'repassword.must'	=> '确认密码必填',
		    'repassword.confirm'=> '两次密码不一致，请重新输入',
		    'gongs.must'		=> '公司名称必填',
		    'gongs.max'			=> '公司名称不得超过50个字符'
		];

		$data = [
			'id'			=> 0,
		    'username'  	=> input('post.username'),
		    'password' 		=> md5(input('post.password')),
		    'repassword'	=> md5(input('post.repassword')),
		    'gongs'			=> input('post.gongs'),
		];


		$validate = Validate::make($rule,$msg);
		if (!$validate->check($data)) {
		    return json($validate->getError());
	    }

	    Db::startTrans();
        try {
		    $zhangtao = model('zhangtao');
		    $fdata['zhangtao'] = input('post.gongs');
		    $zhangt_id = $zhangtao->store($fdata);

		    if($zhangt_id > 0){
		    	$data['closingdate'] = date('Y-m-d',strtotime('+90 day'));
		    	$data['zhangt_id'] = $zhangt_id;
		    	$data['lastlogintime'] = date('Y-m-d H:i:s');
		    	$user = model('user');
		    	$userid = $user->store($data);
			    if(!$userid){
			    	throw new \Exception('用户创建失败');
			    }

			    $fdata1['user_id'] = $userid;
			    $fdata1['jues_id'] = 1;

			    if(!Db::name('userjuese')->insert($fdata1)){
			    	throw new \Exception('角色写入失败');
			    }
		    }else{
		    	throw new \Exception('账套创建失败');
		    }
	    	Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            return json($e->getMessage());
        }
	    
    }


    public function listuser(){
    	$row = Db::table('user')->field('username,lastlogintime')->select();
    	dump($row);
	}
	
	public function xieru(){
		
	}

}
