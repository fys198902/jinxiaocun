<?php
namespace app\index\controller;
use think\Db;
use think\Validate;
use think\Controller;
use think\facade\Session;


class Caig extends Common{
	public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
		    $this->_initialize();
		}
    }


    public function caig_insert(){
        $getcaigxtid=new Getval();
        $this->assign('fdate', date('Y-m-d'));
        $this->assign('xtid',$getcaigxtid->getcaigou_xt_id());
        $row = Db::table('cangku')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('id,cangk_name')
            ->select();
        $this->assign('row', $row);
    	return view('Caig/caig_insert');
    }

    public function caig_insert_do(){
        $this->checkquanxian();

        $riqi=input('post.caig_date');
        $gongysid=input('post.gongysid');
        $zhaiyao=input('post.caig_zhaiy');
        $cangkuid=input('post.caig_cangk_id');
        $wuliaoid=input('post.caig_wuliao_id');
        $danwid=input('post.caig_danw_id');
        $shul=input('post.caig_shul');
        $danj=input('post.caig_danj');
        $jine=input('post.caig_jine');
        $beizhu=input('post.caig_beizhu');

        $getval = new Getval();
        if(!$getval->checkgongysid($gongysid, input('zhangt_id'))){
            $msg['status'] = 0;
            $msg['msg'] = '供应商错误，请检查';
            return json($msg);
            exit();
        }

        if(!$getval->checkjiezhang($riqi)){
            $msg['status'] = 0;
            $msg['msg'] = '此期间已结账，禁止操作';
            return json($msg);
            exit();
        }

        Db::startTrans();
        try {
            $fdata['id'] = 0;
            $fdata['caig_xt_id'] = $getval->getcaigou_xt_id(input('zhangt_id'));
            $fdata['caig_date'] = trim($riqi);
            $fdata['gongys_id'] = trim($gongysid);
            $fdata['caig_cangk_id'] = trim($cangkuid);
            $fdata['caig_zhaiy'] = trim($zhaiyao);
            $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
            $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');
            $zhixing=true;
            $caigou=model('caigou');
            $caigid = $caigou->store($fdata);
            if($caigid>0){
                $t=0;
                for($i=0;$i<count($wuliaoid);$i++){
                    if($wuliaoid[$i]>0 && ($shul[$i] >0 || $shul[$i] <0)){
                        $t++;
                    }
                    
                }

                if($t==0){
                    throw new \Exception('表单不全，请重新输入');  
                }


                for($i=0;$i<$t;$i++){
                    if($wuliaoid[$i]<>''){

                        if(!$getval->checkwuliaoid($wuliaoid[$i], input('zhangt_id'))){
                            throw new \Exception('物料错误，请检查');  
                        }

                        $data['caig_id'] = $caigid;
                        $data['wuliao_id'] = trim($wuliaoid[$i]);
                        $data['danw_id'] = trim($danwid[$i]);
                        $data['shul'] = trim($shul[$i]);
                        $data['danj'] = round(trim($danj[$i]),2);
                        $data['jine'] = round(trim($shul[$i])*trim($danj[$i]),2);
                        $data['beizhu'] = trim($beizhu[$i]);
                        $caigouentry=model('caigouentry');
                        if(!$caigouentry->store($data)){
                            throw new \Exception('单据明细插入失败');
                        }
                    }
                }

            }else{
                throw new \Exception('单据主体插入失败');
            }

            Db::commit();
            $msg['status'] = 1;
            $msg['msg'] = $fdata['caig_xt_id'];
            return json($msg);
        } catch (\Exception $e) {
            Db::rollback();
            $msg['status'] = 0;
            $msg['msg'] = $e->getMessage();
            return json($msg);
        }
        
    }


    public function caig_list(){
        $ksrq=input('ksrq');
        $jsrq=input('jsrq');
        $gongys=input('gongys');
        $pinzhong = input('pinzhong');
        $beizhu=input('beizhu');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['gongys_name|caig_xt_id','like',"%$gongys%"];
        $where[] = ['beizhu','like',"%$beizhu%"];
        $where[] = ['wuliao_name','like',"%$pinzhong%"];

        if($ksrq<>''){
            if($jsrq<>''){
                $where[] = ['caig_date', 'between time', [$ksrq, $jsrq]];
            }else{
                $where[] = ['caig_date', '=', $ksrq];
            }
        }

        $yema=20;
        $row = Db::table('caigoulist')
            ->where($where)
            ->order('caig_xt_id desc')
            ->fetchsql(false)
            ->paginate($yema);
        $yemas = ceil($row->total()/$yema);
        
        $this->assign('ksrq', $ksrq);
        $this->assign('jsrq', $jsrq);
        $this->assign('gongys', $gongys);
        $this->assign('pinzhong', $pinzhong);
        $this->assign('beizhu', $beizhu);


        $page = input('?page')?input('page'):1;

        $qishiye = ($page-5 > 0)?($page-5):0;
        $jieshuye = ($page+5 > $yemas)?$yemas:($page+5);
        $this->assign('qishiye', $qishiye);
        $this->assign('jieshuye', $jieshuye);

        
        $this->assign('row',$row);
        $this->assign('zongshu',$row->total());
        $this->assign('dangqianye',$page);
        $this->assign('yemashu', ceil($row->total()/$yema));
        $this->assign('shangyiye',($page-1)>0?$page-1:1);
        $this->assign('xiayiye',(input('page')+1>$yemas)?$yemas:$page+1);

    	return view('Caig/caig_list');
    }



    public function caig_update(){
        $row = Db::table('caigoulist')
            ->where('id','=',input('id'))
            ->select();

        $cangku = Db::table('cangku')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('id,cangk_name')
            ->select();

        $this->assign('row', $row);
        $this->assign('cangku', $cangku);
        return view('Caig/caig_update');
    }

    public function caig_update_do(){
        $this->checkquanxian();

        $id = input('post.id');
        $riqi=input('post.caig_date');
        $gongysid=input('post.gongysid');
        $zhaiyao=input('post.caig_zhaiy');
        $cangkuid=input('post.caig_cangk_id');
        $wuliaoid=input('post.caig_wuliao_id');
        $danwid=input('post.caig_danw_id');
        $shul=input('post.caig_shul');
        $danj=input('post.caig_danj');
        $jine=input('post.caig_jine');
        $beizhu=input('post.caig_beizhu');


        $getval = new Getval();
        if(!$getval->checkgongysid($gongysid)){
            $msg['status'] = 0;
            $msg['msg'] = '供应商错误，请检查';
            return json($msg);
            exit();
        }


        if(!$getval->checkjiezhang($riqi)){
            $msg['status'] = 0;
            $msg['msg'] = '此期间已结账，禁止操作';
            return json($msg);
            exit();
        }

        Db::startTrans();
        try {
            $fdata['id'] = $id;
            $fdata['caig_xt_id'] = input('caig_xt_id');
            $fdata['caig_date'] = trim($riqi);
            $fdata['gongys_id'] = trim($gongysid);
            $fdata['caig_zhaiy'] = trim($zhaiyao);
            $fdata['caig_cangk_id'] = trim($cangkuid);
            $fdata['user_id'] = session('userid');
            $fdata['zhangt_id'] = session('zhangtao_id');

            $caigou=model('caigou');
            $caigou->store($fdata);

            $t=0;
            for($i=0;$i<count($wuliaoid);$i++){
                if($wuliaoid[$i]>0 && ($shul[$i] >0 || $shul[$i] <0)){
                    $t++;
                }
                
            }

            if($t==0){
                throw new \Exception('表单不全，请重新输入');
            }

            if(!Db::table('caigouentry')->where('caig_id','=', $id)->delete()){
                throw new \Exception('单据明细删除失败');
            }

            for($i=0; $i<$t; $i++){
                if($wuliaoid[$i]<>''){

                    if(!$getval->checkwuliaoid($wuliaoid[$i])){
                        throw new \Exception('物料错误，请检查');  
                    }

                    $data['caig_id'] = trim($id);
                    $data['wuliao_id'] = trim($wuliaoid[$i]);
                    $data['danw_id'] = trim($danwid[$i]);
                    $data['shul'] = trim($shul[$i]);
                    $data['danj'] = round(trim($danj[$i]),2);
                    $data['jine'] = round(trim($shul[$i])*trim($danj[$i]),2);
                    $data['beizhu'] = trim($beizhu[$i]);
                    $caigouentry=model('caigouentry');
                    if(!$caigouentry->store($data)){
                        throw new \Exception('单据明细插入失败');
                    }
                }
            }

            Db::commit();
            $msg['status'] = 1;
            $msg['msg'] = $fdata['caig_xt_id'];
            return json($msg);
        } catch (\Exception $e) {
            Db::rollback();
            $msg['status'] = 0;
            $msg['msg'] = $e->getMessage();
            return json($msg);
        }
        
    }


    public function caig_del(){
        $this->checkquanxian();

        $id = input('post.caig_id');
        $xtid = input('post.caig_xtid');


        $fdate = Db::table('caigou')->where('id','=',$id)->value('caig_date');
        $getval = new Getval();
        if(!$getval->checkjiezhang($fdate)){
            $msg['status'] = 0;
            $msg['msg'] = '本期间已结账，禁止删除';
            return json($msg);
        }


        Db::startTrans();
        try {
            if(!Db::table('caigou')->where('id','=',$id)->delete()){
                throw new \Exception('表单主体删除失败');
            }
            if(!Db::table('caigouentry')->where('caig_id','=',$id)->delete()){
                throw new \Exception('表单明细删除失败');
            }
            Db::commit();
            $msg['status'] = 1;
            $msg['msg'] = $xtid.'--删除成功！';
            return json($msg);
        } catch (\Exception $e) {
            Db::rollback();
            $msg['status'] = 0;
            $msg['msg'] = $e->getMessage();
            return json($msg);
        }
    }


    public function caigoudaochu(){
        $this->checkquanxian();

        $ksrq=input('ksrq');
        $jsrq=input('jsrq');
        $gongys=input('gongys');
        $pinzhong = input('pinzhong');
        $beizhu=input('beizhu');

        $where[] = ['zhangt_id', '=', session('zhangtao_id')];
        $where[] = ['gongys_name|caig_xt_id','like',"%$gongys%"];
        $where[] = ['beizhu','like',"%$beizhu%"];
        $where[] = ['wuliao_name','like',"%$pinzhong%"];

        if($ksrq<>''){
            if($jsrq<>''){
                $where[] = ['caig_date', 'between time', [$ksrq, $jsrq]];
            }else{
                $where[] = ['caig_date', '=', $ksrq];
            }
        }

        $row = Db::table('caigoulist')->where($where)->order('caig_xt_id desc')->select();
        $daochu = new Daochu;
        $daochu->caigoudaochu($row);
    }

}
