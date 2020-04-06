<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;


class Hout extends Common{
	public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
		    $this->_initialize();
		}
    }

    public function danw(){
        $row = Db::table('danw')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        $rowentry = Db::table('danwlist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        $this->assign('rowentry', $rowentry);
        $this->assign('row', $row);
        return view('Hout/danw');
    }

    public function danw_zu_do(){
        $this->checkquanxian();

    	$fdata['id']=0;
    	$fdata['danw_zu'] = input('zuming');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');
 		$danw = model('danw');
    	if($danw->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '插入成功';
    	}else{
            $msg['status'] = 0;
            $msg['msg'] = '插入失败';
        }
        return json($msg);
    }


    public function danw_zu_update_do(){
        $this->checkquanxian();

        $fdata['id']= input('zuid');
        $fdata['danw_zu'] = input('zuming');
        $fdata['user_id'] = session('userid');
        $fdata['zhangt_id'] = session('zhangtao_id');

        $danw = model('danw');
        $danw->store($fdata);
        $msg['status'] = 1;
        $msg['msg'] = '修改成功';
        return json($msg);
    }

    public function danwentry_do(){
        $this->checkquanxian();

        $jiben = input('jiben');
        $danwentry = model('danwentry');
        $fdata['id'] = 0;
        $fdata['danw_zu_id'] = input('zuid');
        $fdata['danw_name'] = input('danw_name');
        $fdata['danw_huans'] = ($jiben=='true')?1:input('huansuan');
        $fdata['danw_leibie'] = ($jiben=='true')?0:100;
        if($danwentry->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '插入成功';
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '插入失败';
        }
        return json($msg);
    }

    public function danwentry_update_do(){
        $this->checkquanxian();

        $jiben = input('jiben');
        $danwentry = model('danwentry');
        $fdata['id'] = input('id');
        $fdata['danw_zu_id'] = input('zuid');
        $fdata['danw_name'] = input('danw_name');
        $fdata['danw_huans'] = ($jiben=='true')?1:input('huansuan');
        $fdata['danw_leibie'] = ($jiben=='true')?0:100;

        $data['danw_name'] = input('danw_name');
        $data['danw_huans'] = ($jiben=='true')?1:input('huansuan');
        Db::table('xiaoshouentry')->where('danw_id', input('id'))->update($data);

        $danwentry->store($fdata);
        $msg['status'] = 1;
        $msg['msg'] = '修改成功';
        return json($msg);
    }

    public function danwzu_del(){
        $this->checkquanxian();

        $id = input('id');
        if(Db::table('danwentry')->where('danw_zu_id','=',$id)->count()==0){
            if(Db::table('danw')->where('id','=',$id)->delete()){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg);
            }
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '单位组还有子项目未删除，删除后才能删除该父级项目';
            return json($msg);
        }        
    }

    public function danwentry_del(){
        $this->checkquanxian();

        $id = input('id');

        $caigoushul = Db::table('caigouentry')
            ->where('danw_id','=',$id)
            ->count();

        $xiaoshoushul = Db::table('xiaoshouentry')
            ->where('danw_id','=',$id)
            ->count();

        if($caigoushul==0 && $xiaoshoushul==0){
            if(Db::table('danwentry')->where('id','=',$id)->delete()){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg);
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '删除失败';
                return json($msg);
            }
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '此单位已被使用，禁止删除';
            return json($msg);
        }
    }

    public function wuliao(){
        $row = Db::table('danw')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        $wuliaozu = Db::table('wuliaozu')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        $wuliao = Db::table('wuliaolist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();

        $this->assign('row', $row);
        $this->assign('wuliaolist', $wuliao);
        $this->assign('wuliaozu', $wuliaozu);
        return view('Hout/wuliao');
    }

    public function wuliaozu_do(){
        $this->checkquanxian();

        $fdata['id']= input('id');
        $fdata['wuliao_zu'] = input('wuliaozu');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');

        $wuliaozu = model('wuliaozu');
        if($wuliaozu->store($fdata)>=0){
            $msg['status'] = 1;
            $msg['msg'] = '操作成功';
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '操作失败';
        }
        return json($msg);
    }

    public function wuliaozu_del(){
        $wuliaozuid = input('wuliaozuid');
        if(Db::table('wuliao')->where('zu_id', $wuliaozuid)->count()>0){
            $msg['status'] = 0;
            $msg['msg'] = '此物料组已被使用，禁止删除';
            return json($msg);
        }else{
            if(Db::table('wuliaozu')->where('id', $wuliaozuid)->delete()){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg);
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '删除失败';
                return json($msg);
            }
        }
    }

    public function wuliao_do(){
        $this->checkquanxian();

        $wuliao = model('wuliao');
        $fdata['id'] = 0;
        $fdata['zu_id'] = input('zuid');
        $fdata['wuliao_name'] = input('wuliao');
        $fdata['danw_zu_id'] = input('danwzuid');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');

        if($wuliao->checkunique(input('wuliao'),input('zhangt_id')) > 0){
            $msg['status'] = 0;
            $msg['msg'] = '物料名称重复，请重新输入';
            return json($msg);
        }

        if($wuliao->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '操作成功';
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '操作失败';
        }
        return json($msg);
    }

    public function wuliao_update_do(){
        $this->checkquanxian();

        $wuliao = model('wuliao');
        $fdata['id'] = input('id');
        $fdata['zu_id'] = input('zuid');
        $fdata['wuliao_name'] = input('wuliao');
        $fdata['danw_zu_id'] = input('danwzuid');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');

        $data['wuliao_name'] = input('wuliao');
        Db::table('xiaoshouentry')->where('wuliao_id', input('id'))->update($data);

        $wuliao->store($fdata);
        $msg['status'] = 0;
        $msg['msg'] = '修改成功';
        return json($msg);            
    }

    public function wuliao_del(){
        $this->checkquanxian();
        $wuliaoid = input('wuliaoid');

        $xiaoscount = Db::table('xiaoshoulist')
            ->where('wuliaoid', $wuliaoid)
            ->count();
        $caigoucount = Db::table('caigoulist')
            ->where('wuliaoid', $wuliaoid)
            ->count();
        if($xiaoscount + $caigoucount >0){
            $msg['status'] = 0;
            $msg['msg'] = '此物料已被使用，禁止删除';
            return json($msg);
        }else{
            if(Db::table('wuliao')->where('id',$wuliaoid)->delete()){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg);
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '删除失败';
                return json($msg);
            }
        }
    }


    public function getwuliao(){
        $id = input('wuliaoid');
        $row = Db::table('wuliaolist')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->where('id','=',$id)
            ->select();
        return json($row);
    }

    public function kehu(){
        $kehu = input('kehu');
        $dizhi = input('dizhi');
        $lianxr = input('lianxr');
        $lianxfs = input('lianxfs');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['kehu_name','like',"%$kehu%"];
        $where[] = ['kehu_dizhi','like',"%$dizhi%"];
        $where[] = ['kehu_lianxr','like',"%$lianxr%"];
        $where[] = ['kehu_lianxfs','like',"%$lianxfs%"];


        $yema=20;
        $row = Db::table('kehu')->where($where)->paginate($yema);
        $yemas = ceil($row->total()/$yema);

        $page = input('?page')?input('page'):1;
        $qishiye = ($page-5 > 0)?($page-5):0;
        $jieshuye = ($page+5 > $yemas)?$yemas:($page+5);
        
        $this->assign('row',$row);
        $this->assign('zongshu',$row->total());
        $this->assign('dangqianye',$page);
        $this->assign('yemashu', ceil($row->total()/$yema));
        $this->assign('shangyiye',($page-1)>0?$page-1:1);
        $this->assign('xiayiye',($page+1>$yemas)?$yemas:$page+1);
        $this->assign('qishiye', $qishiye);
        $this->assign('jieshuye', $jieshuye);

        $this->assign('kehu', $kehu);
        $this->assign('dizhi', $dizhi);
        $this->assign('lianxr', $lianxr);
        $this->assign('lianxfs', $lianxfs);


        return view('Hout/kehu');
    }

    public function kehu_do(){
        $this->checkquanxian();

        $fdata['id'] = 0;
        $fdata['kehu_name'] = input('name');
        $fdata['kehu_dizhi'] = input('dizhi');
        $fdata['kehu_lianxr'] = input('lianxr');
        $fdata['kehu_lianxfs'] = input('lianxfs');
        $fdata['user_id'] = input('userid')>0?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('zhangt_id')>0?input('zhangt_id'):session('zhangtao_id');

        $kehu = model('kehu');

        if($kehu->checkunique(input('name')) > 0){
            $msg['status'] = 0;
            $msg['msg'] = '客户名重复，请重新输入';
            return json($msg);
        }

        if($kehu->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '插入成功';
            return json($msg);
        }

    }

    public function kehu_update_do(){
        $this->checkquanxian();

        $fdata['id'] = input('id');
        $fdata['kehu_name'] = input('name');
        $fdata['kehu_dizhi'] = input('dizhi');
        $fdata['kehu_lianxr'] = input('lianxr');
        $fdata['kehu_lianxfs'] = input('lianxfs');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        
        $data['kehu_name'] = input('name');
        $data['kehu_dizhi'] = input('dizhi');
        $data['kehu_lianxfs'] = input('lianxfs');
        Db::table('xiaoshou')
            ->where('kehu_id', input('id'))
            ->update($data);

        $kehu = model('kehu');
        $kehu->store($fdata);
        $msg['status'] = 1;
        $msg['msg'] = '修改成功';
        return json($msg);
    }


    public function kehu_del(){
        $this->checkquanxian();

        $xiaos_shul = Db::table('xiaoshou')->where('kehu_id','=',input('id'))->count();
        $shouk_shul = Db::table('shoukuan')->where('kehu_id','=',input('id'))->count();

        if($xiaos_shul + $shouk_shul ==0){
            if(Db::table('kehu')->where('id','=',input('id'))->delete()){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg);
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '删除失败';
                return json($msg);
            }
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '客户已被使用，禁止删除';
            return json($msg);
        }
        
    }


    public function kehudaochu(){
        $this->checkquanxian();

        $kehu = input('kehu');
        $dizhi = input('dizhi');
        $lianxr = input('lianxr');
        $lianxfs = input('lianxfs');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['kehu_name','like',"%$kehu%"];
        $where[] = ['kehu_dizhi','like',"%$dizhi%"];
        $where[] = ['kehu_lianxr','like',"%$lianxr%"];
        $where[] = ['kehu_lianxfs','like',"%$lianxfs%"];
        
        $row = Db::table('kehu')->where($where)->select();
        $daochu = new Daochu;
        $daochu->kehudaochu($row);
    }



    public function gongys(){
        $row = Db::table('gongys')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();
        $this->assign('row', $row);
        return view('Hout/gongys');
    }

    public function gongys_do(){
        $this->checkquanxian();

        $fdata['id'] = 0;
        $fdata['gongys_name'] = input('name');
        $fdata['gongys_dizhi'] = input('dizhi');
        $fdata['gongys_lianxr'] = input('lianxr');
        $fdata['gongys_lianxfs'] = input('lianxfs');
        $fdata['user_id'] = input('userid')>0?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('zhangt_id')>0?input('zhangt_id'):session('zhangtao_id');

        $gongys = model('gongys');

        if($gongys->checkunique(input('name')) > 0){
            $msg['status'] = 0;
            $msg['msg'] = '供应商名称重复，请重新输入';
            return json($msg);
        }

        if($gongys->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '插入成功';
            return json($msg);
        }

    }

    public function gongys_update_do(){
        $this->checkquanxian();

        $fdata['id'] = input('id');
        $fdata['gongys_name'] = input('name');
        $fdata['gongys_dizhi'] = input('dizhi');
        $fdata['gongys_lianxr'] = input('lianxr');
        $fdata['gongys_lianxfs'] = input('lianxfs');
        $fdata['user_id'] = input('userid')>0?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('zhangt_id')>0?input('zhangt_id'):session('zhangtao_id');

        $gongys = model('gongys');
        $gongys->store($fdata);
        $msg['status'] = 1;
        $msg['msg'] = '修改成功';
        return json($msg);
    }


    public function gongys_del(){
        $this->checkquanxian();

        $caig_shul =Db::table('caigou')->where('gongys_id','=',input('id'))->count();
        $fukuan_shul = Db::table('fukuan')->where('gongys_id','=',input('id'))->count();

        if($caig_shul + $fukuan_shul ==0){
            if(Db::table('gongys')->where('id','=',input('id'))->delete()){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg);
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '删除失败';
                return json($msg);
            }
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '此供应商已被使用，禁止删除';
            return json($msg);
        }
        
    }

    public function user(){
        $row = Db::table('user_juesename')->select();
        $jues = Db::table('juese')->select();
        $this->assign('row', $row);
        $this->assign('juese', $jues);
        return view('Hout/user');
    }

    public function user_do(){
        $this->checkquanxian();

        $username = input('username');
        $password = input('password');
        $jueseid = input('jueseid');

        Db::startTrans();
        try {
            $fdata['id'] = 0;
            $fdata['username'] = $username;
            $fdata['password'] = md5($password);
            $fdata['status'] = 1;
            $user = model('user');
            $user_id = $user->store($fdata);
            if($user_id<0){
                throw new \Exception('用户插入失败');
            }

            $fdata1['id'] = 0;
            $fdata1['user_id'] = $user_id;
            $fdata1['jues_id'] = $jueseid;

            $user_juese = model('userjuese');

            if(!$user_juese->store($fdata1)){
                throw new \Exception('角色写入失败');
            }
            Db::commit();
            return json('插入成功');
        } catch (\Exception $e) {
            Db::rollback();
            return json($e->getMessage());
        }
    }


    public function user_status(){
        $this->checkquanxian();

        $user_id = input('id');
        $status = input('status');

        $juese_id = Db::table('user_juesename')->where('id','=',$user_id)->value('jueseid');

        if($juese_id == 1){
            if(Db::table('user_juesename')->where('jueseid','=',1)->count() == 1){
                return json('此为最后一名管理员，不得禁用');
            }
        }
        
        if(Db::table('user')->where('id',$user_id)->setField('status', $status)){
            return json('设定成功');
        }else{
            return json('设定失败');
        }

    }


    public function user_del(){
        $this->checkquanxian();

        $id = input('id');
        $caigou_shul = Db::table('caigou')->where('user_id','=',$id)->count();
        $cangku_shul = Db::table('cangku')->where('user_id','=',$id)->count();
        $danw_shul = Db::table('danw')->where('user_id','=',$id)->count();
        $fukuan_shul = Db::table('fukuan')->where('user_id','=',$id)->count();
        $gongys_shul = Db::table('gongys')->where('user_id','=',$id)->count();
        $jiezhang_shul = Db::table('jiezhang')->where('user_id','=',$id)->count();
        $kehu_shul = Db::table('kehu')->where('user_id','=',$id)->count();
        $qitashouzhi_shul = Db::table('qitashouzhi')->where('user_id','=',$id)->count();
        $shoukuan_shul = Db::table('shoukuan')->where('user_id','=',$id)->count();
        $wuliao_shul = Db::table('wuliao')->where('user_id','=',$id)->count();
        $xiaoshou_shul = Db::table('xiaoshou')->where('user_id','=',$id)->count();
        $yuang_shul = Db::table('yuangong')->where('user_id','=',$id)->count();
        $zhangtao_shul = Db::table('zhangtao')->where('user_id','=',$id)->count();

        $juese_id = Db::table('user_juesename')->where('id','=',$id)->value('jueseid');


        if($juese_id == 1){
            if(Db::table('user_juesename')->where('jueseid','=',1)->count() == 1){
                return json('此为最后一名管理员，不得删除');
            }
        }



        if($caigou_shul + $cangku_shul + $danw_shul + $fukuan_shul + $gongys_shul + $jiezhang_shul + $kehu_shul + $qitashouzhi_shul + $shoukuan_shul + $wuliao_shul + $xiaoshou_shul + $yuang_shul + $zhangtao_shul == 0){
            if(Db::table('user')->delete($id)){
                return json('删除成功');
            }else{
                return json('删除失败');
            }
        }else{
            return json('此用户已被使用不允许删除');
        }
        
    }

    public function user_update(){
        $this->checkquanxian();

        $row = Db::table('user')->where('id', '=', session('userid'))->field('password')->select();
        if($row[0]['password'] == md5(input('zhut_pwd'))){
            Db::name('user')->where('id', session('userid'))->setField('password', md5(input('zhut_new_pwd')));
            return json('密码修改成功');
        }else{
            return json('密码错误');
        }
    }

    public function user_set_juese(){
        $this->checkquanxian();

        $jueseid = input('jueseid');

        $juese_id = Db::table('user_juesename')->where('id','=',input('userid'))->value('jueseid');


        if($juese_id == 1){
            if(Db::table('user_juesename')->where('jueseid','=',1)->count() == 1){
                return json('此为最后一名管理员，不得更改');
            }
        }


        if(Db::name('userjuese')->where('user_id','=',input('userid'))->setField('jues_id', $jueseid)){
            return json('修改成功');
        }else{
            return json('修改失败');
        }
    }


    public function user_pwd_chongzhi(){
        $this->checkquanxian();

        Db::name('user')->where('id', '=', input('id'))->setField('password', md5(input('newpwd')));
        return json('密码重置成功');
    }


    public function yuangong(){
        $row = Db::table('yuangong')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();

        $this->assign('row', $row);
        return view('Hout/yuangong');
    }


    public function yuangong_do(){
        $this->checkquanxian();

        $fdata['id'] = 0;
        $fdata['yuang']= input('yuang');
        $fdata['lianxfs'] = input('lianxfs');
        $fdata['user_id'] = session('userid');
        $fdata['zhangt_id'] = session('zhangtao_id');

        $yuangong = model('yuangong');
        if($yuangong->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '插入成功';
            return json($msg);
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '插入失败';
            return json($msg);
        }

    }


    public function yuangong_update(){
        $this->checkquanxian();

        $fdata['id'] = input('id');
        $fdata['yuang']= input('yuang');
        $fdata['lianxfs'] = input('lianxfs');
        $fdata['user_id'] = session('userid');
        $fdata['zhangt_id'] = session('zhangtao_id');

        $yuangong = model('yuangong');
        $yuangong->store($fdata);
        $msg['status'] = 1;
        $msg['msg'] = '修改成功';
        return json($msg);
    }

    public function yuangong_del(){
        $this->checkquanxian();

        $id = input('id');
        $yuang_shul = Db::table('xiaoshou')
            ->where('yuang_id','=',$id)
            ->count();

        if($yuang_shul == 0){
            Db::table('yuangong')->delete($id);
            $msg['status'] = 1;
            $msg['msg'] = '删除成功';
            return json($msg);   
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '此员工已被使用不允许删除';
            return json($msg); 
        }
    }


    public function cangku(){
        $row = Db::table('cangku')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();

        $this->assign('row', $row);
        return view('Hout/cangku');
    }

    public function cangku_do(){
        $this->checkquanxian();

        $fdata['id'] = 0;
        $fdata['cangk_name'] = input('cangku_name');
        $fdata['cangk_dizhi'] = input('cangku_dizhi');
        $fdata['cangk_lianxfs'] = input('cangku_lianxfs');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');

        $cangku = model('cangku');

        if($cangku->checkunique(input('cangku_name')) > 0){
            $msg['status'] = 0;
            $msg['msg'] = '仓库名称重复，请重新输入';
            return json($msg); 
        }

        if($cangku->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '插入成功';
            return json($msg); 
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '插入失败';
            return json($msg); 
        }
    }

    public function cangku_del(){
        $this->checkquanxian();

        $id = input('id');
        $caigou_shul = Db::table('caigou')
            ->where('caig_cangk_id','=', $id)
            ->count();

        $xiaoshou_shul = Db::table('xiaoshou')
            ->where('xiaos_cangk_id','=', $id)
            ->count();

        if($caigou_shul + $xiaoshou_shul == 0){
            if(Db::table('cangku')->delete($id)){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg); 
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '删除失败';
                return json($msg); 
            }
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '此仓库已被使用禁止删除';
            return json($msg); 
        }
    }

    public function cangku_update(){
        $this->checkquanxian();
        
        $fdata['id'] = input('id');
        $fdata['cangk_name'] = input('cangku_name');
        $fdata['cangk_dizhi'] = input('cangku_dizhi');
        $fdata['cangk_lianxfs'] = input('cangku_lianxfs');
        $fdata['user_id'] = session('userid');
        $fdata['zhangt_id'] = session('zhangtao_id');

        $cangku = model('cangku');

        $cangku->store($fdata);
        $msg['status'] = 1;
        $msg['msg'] = '修改成功';
        return json($msg); 
    }


    public function kehudaoru(){
        $file = request()->file('excel');
        $info = $file->move( 'public/tmp');
        $daoru = new Daoru;
        $lujing = 'public/tmp/'.$info->getSaveName();
        $row = $daoru->kehu_daoru($lujing);
        @unlink($lujing);
        @rmdir('public/tmp/' . date('Ymd'));
        return json($row->getData());
    }


    public function gongysdaoru(){
        $file = request()->file('excel');
        $info = $file->move( 'public/tmp');
        $daoru = new Daoru;
        $lujing = 'public/tmp/'.$info->getSaveName();
        $row = $daoru->gongys_daoru($lujing);
        @unlink($lujing);
        rmdir('public/tmp/' . date('Ymd'));
        return json($row->getData());
    }

    public function shoukleibie(){
        $row = Db::table('shoukuanleibie')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();
        $this->assign('row', $row);
        return view('Hout/shoukleibie');
    }

    public function shoukleibie_do(){
        $fdata['id'] = 0;
        $fdata['shoukleibie'] = input('shoukleibie');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');

        $shoukuanleibie = model('shoukuanleibie');

        if($shoukuanleibie->checkunique(input('shoukleibie'),input('zhangt_id')) > 0){
            $msg['status'] = 0;
            $msg['msg'] = '收款类别重复，请重新输入';
            return json($msg); 
        }

        if($shoukuanleibie->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = '插入成功';
            return json($msg);
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '插入失败';
            return json($msg);
        }
    }

    public function shoukleibie_update(){
        $fdata['id'] = input('id');
        $fdata['shoukleibie'] = input('shoukleibie');
        $fdata['user_id'] = session('userid');
        $fdata['zhangt_id'] = session('zhangtao_id');

        $shoukuanleibie = model('shoukuanleibie');

        $shoukuanleibie->store($fdata);
        $msg['status'] = 1;
        $msg['msg'] = '修改成功';
        return json($msg);

    }


    public function shoukleibie_del(){

        $id = input('id');
        $shouk_shul = Db::table('shoukuan')
            ->where('shoukleibie_id','=', $id)
            ->count();
        $fukuan_shul = Db::table('fukuan')
            ->where('shoukleibie_id','=', $id)
            ->count();
        $qita_shul = Db::table('qitashouzhi')
            ->where('shoukleibie_id','=', $id)
            ->count();


        if($shouk_shul + $fukuan_shul + $qita_shul == 0){
            if(Db::table('shoukuanleibie')->delete($id)){
                $msg['status'] = 1;
                $msg['msg'] = '删除成功';
                return json($msg);
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '删除失败';
                return json($msg);
            }
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '此收款类别已被使用禁止删除';
            return json($msg);
        }
    }

}
