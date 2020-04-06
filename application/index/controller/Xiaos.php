<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;


class Xiaos extends Common{
	public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
		    $this->_initialize();
		}
    }


    public function xiaos_insert(){
        $getval=new Getval();
        $this->assign('xsid',$getval->getxiaos_xt_id());
        $this->assign('fdate' , date('Y-m-d'));
        $row = Db::table('cangku')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('id,cangk_name')
            ->select();

        $leibie = Db::table('shoukuanleibie')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();

        $this->assign('row', $row);
        $this->assign('leibie', $leibie);
    	return view('Xiaos/xiaos_insert');
    }


    public function xiaos_insert_do(){
        $this->checkquanxian();

        $riqi = input('post.xiaos_date');
        $kehuid = input('post.kehuid');
        $cangkuid = input('post.xiaos_cangk_id');
        $zhaiyao = input('post.xiaos_zhaiy');
        $shoukuanleibie_id = input('post.xiaos_shoukleibie_id');
        $wuliaoid = input('post.xiaos_wuliao_id');
        $danwid = input('post.xiaos_danw_id');
        $shul = input('post.xiaos_shul');
        $danj = input('post.xiaos_danj');
        $jine = input('post.xiaos_jine');
        $beizhu = input('post.xiaos_beizhu');
        $shoukuan_jine = input('xiaoshou_shoukuan_jine');
        $shoukuan_zhaiyao = input('xiaoshou_shoukuan_zhaiyao');
        $shoukuan_zhekou = input('xiaoshou_shoukuan_zhekou');

        $getval = new Getval();

        if(!$getval->checkkehuid($kehuid, input('zhangt_id'))){
            $msg['status'] = 0;
            $msg['msg'] = '客户错误，请检查';
            return json($msg);
            exit();
        }

        if(!$getval->checkjiezhang($riqi)){
            $msg['status'] = 0;
            $msg['msg'] = '本期间已结账，禁止操作';
            return json($msg);
            exit();
        }



        Db::startTrans();
        try {
            $fdata['id']=0;
            $fdata['xiaos_xt_id'] = $getval->getxiaos_xt_id(input('zhangt_id'));
            $fdata['xiaos_date'] = trim($riqi);
            $fdata['kehu_id'] = trim($kehuid);
            $fdata['xiaos_zhaiy'] = trim($zhaiyao);
            $fdata['xiaos_cangk_id'] = trim($cangkuid);
            $fdata['user_id'] = input('userid')>0?input('userid'):session('userid');
            $fdata['zhangt_id'] = input('zhangt_id')>0?input('zhangt_id'):session('zhangtao_id');
            $kehuinfo = Db::table('kehu')->where('id', trim($kehuid))->find();
            $fdata['kehu_name'] = $kehuinfo['kehu_name'];
            $fdata['kehu_dizhi'] = $kehuinfo['kehu_dizhi'];
            $fdata['kehu_lianxfs'] = $kehuinfo['kehu_lianxfs'];
            $cangkuinfo = Db::table('cangku')->where('id', trim($cangkuid))->find();
            $fdata['cangk_name'] = $cangkuinfo['cangk_name'];
            $fdata['cangk_lianxfs'] = $cangkuinfo['cangk_lianxfs'];
            $fdata['username'] = Db::table('user')->where('id', session('userid'))->value('username');

            $xiaoshou=model('xiaoshou');

            if(!$getval->checkkehuid($kehuid, input('zhangt_id'))){
                $msg['status'] = 0;
                $msg['msg'] = '客户错误，请检查';
                return json($msg);
                exit();
            }

            $xiaosid = $xiaoshou->store($fdata);

            if($xiaosid>0){
                $t=0;
                for($i=0;$i<count($wuliaoid);$i++){
                    if($wuliaoid[$i]>0 && ($shul[$i] >0 || $shul[$i] <0)){
                        $t++;
                    }
                }


                if($t==0){
                    throw new \Exception('表单不全，请重新输入');
                }

                $ftmp = false;
                for($i=0;$i<$t;$i++){
                    if($wuliaoid[$i]<>''){
                        if(!$getval->checkwuliaoid($wuliaoid[$i], input('zhangt_id'))){
                            throw new \Exception('物料错误，请检查');  
                        }


                        $data['xiaos_id'] = $xiaosid;
                        $data['wuliao_id'] = trim($wuliaoid[$i]);
                        $data['danw_id'] = trim($danwid[$i]);
                        $data['wuliao_name'] = Db::table('wuliao')->where('id', trim($wuliaoid[$i]))->value('wuliao_name');
                        $danweiinfo = Db::table('danwentry')->where('id', trim($danwid[$i]))->find();
                        $data['danw_name'] = $danweiinfo['danw_name'];
                        $data['danw_huans'] = $danweiinfo['danw_huans'];
                        $data['shul'] = trim($shul[$i]);
                        $data['danj'] = round(trim($danj[$i]),2);
                        $data['jine'] = round(trim($shul[$i])*trim($danj[$i]),2);
                        $data['beizhu'] = trim($beizhu[$i]);
                        $xiaoshouentry=model('xiaoshouentry');
                        if($xiaoshouentry->store($data)==0){
                            throw new \Exception('单据明细插入失败');
                        }else{
                            $ftmp = true;
                        }
                    }
                }
                if(!$ftmp){
                    throw new \Exception('单据明细插入失败');
                }
            }else{
                throw new \Exception('单据主体插入失败');
            }


            if($shoukuan_jine >0 || $shoukuan_zhekou >0){
                $shoukuan = model('shoukuan');
                $fdata1['id'] = 0;
                $fdata1['shouk_xt_id'] = $getval->getshouk_xt_id(input('zhangt_id'));
                $fdata1['fdate'] = date('Y-m-d');
                $fdata1['kehu_id'] = trim($kehuid);
                $fdata1['zhaiyao'] = trim($shoukuan_zhaiyao);
                $fdata1['shoukleibie_id'] = trim($shoukuanleibie_id);
                $fdata1['shishou'] = trim($shoukuan_jine);
                $fdata1['zhekou'] = trim($shoukuan_zhekou);
                $fdata1['user_id'] = input('userid')>0?input('userid'):session('userid');
                $fdata1['zhangt_id'] = input('zhangt_id')>0?input('zhangt_id'):session('zhangtao_id');

                $shoukuan_id = $shoukuan->store($fdata1);
                
                if(!$shoukuan_id){
                    throw new \Exception('收款单主体插入失败');
                }

                $fdata2['shouk_id'] = $shoukuan_id;
                $fdata2['xiaoshou_id'] = $fdata['xiaos_xt_id'];

                if(!Db::name('shoukuanentry')->insert($fdata2)){
                    throw new \Exception('收款单明细插入失败');
                }
                $msg['shouk_xt_id'] = $fdata1['shouk_xt_id'];
            }else{
                $msg['shouk_xt_id'] = '';
            }


            Db::commit();
            $msg['status'] = 1;
            $msg['id'] = $xiaosid;
            $msg['xiaosid'] = $fdata['xiaos_xt_id'];
            $msg['xiaosnextid'] = $getval->getxiaos_xt_id();
            return json($msg);            
        } catch (\Exception $e) {
            Db::rollback();
            $msg['status'] = 0;
            $msg['msg'] = $e->getMessage();
            return json($msg);
        }
        
    }


    public function xiaos_list(){
        $ksrq=input('ksrq');
        $jsrq=input('jsrq');
        $kehu=input('kehu');
        $pinzhong = input('pinzhong');
        $beizhu=input('beizhu');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['kehu_name|xiaos_xt_id','like',"%$kehu%"];
        $where[] = ['beizhu','like',"%$beizhu%"];
        $where[] = ['wuliao_name','like',"%$pinzhong%"];

        if($ksrq<>''){
            if($jsrq<>''){
                $where[] = ['xiaos_date', 'between time', [$ksrq, $jsrq]];
            }else{
                $where[] = ['xiaos_date', '=', $ksrq];
            }
        }else{
            $where[] = ['xiaos_date', '=', date('Y-m-d')];
        }



        $yema=20;
        $row = Db::table('xiaoshoulist')
            ->where($where)
            ->order('xiaos_xt_id desc')
            ->select();
            // ->paginate($yema);
        $row_juhe = Db::table('xiaoshoulist')
            ->where($where)
            ->field('danw_name,sum(shul) as xiaolheji, sum(jine) as jineheji')
            ->group('danw_name')
            ->select();
            
        // $yemas = ceil($row->total()/$yema);

        $this->assign('ksrq', $ksrq);
        $this->assign('jsrq', $jsrq);
        $this->assign('kehu', $kehu);
        $this->assign('pinzhong', $pinzhong);
        $this->assign('beizhu', $beizhu);

        
        // $page = input('?page')?input('page'):1;

        // $qishiye = ($page-5 > 0)?($page-5):0;
        // $jieshuye = ($page+5 > $yemas)?$yemas:($page+5);
        // $this->assign('qishiye', $qishiye);
        // $this->assign('jieshuye', $jieshuye);
        
        $this->assign('row',$row);
        $this->assign('row_juhe',$row_juhe);
        // $this->assign('zongshu',$row->total());
        // $this->assign('dangqianye',$page);
        // $this->assign('yemashu', ceil($row->total()/$yema));
        // $this->assign('shangyiye',($page-1)>0?$page-1:1);
        // $this->assign('xiayiye',($page+1>$yemas)?$yemas:$page+1);

        return view('Xiaos/xiaos_list');
    }

    public function xiaos_update(){
        $row = Db::table('xiaoshoulist')
            ->where('id','=',input('id'))
            ->select();
        $this->assign('row', $row);
        $cangku = Db::table('cangku')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('id,cangk_name')
            ->select();
        $this->assign('cangku', $cangku);
        return view('Xiaos/xiaos_update');
    }

    public function xiaos_update_do(){
        $this->checkquanxian();

        $id = input('post.id');
        $riqi=input('post.xiaos_date');
        $kehuid=input('post.kehuid');
        $zhaiyao=input('post.xiaos_zhaiy');
        $cangkuid=input('post.xiaos_cangk_id');
        $jingsr_id = input('post.xiaos_jingsr_id');
        $wuliaoid=input('post.xiaos_wuliao_id');
        $danwid=input('post.xiaos_danw_id');
        $shul=input('post.xiaos_shul');
        $danj=input('post.xiaos_danj');
        $jine=input('post.xiaos_jine');
        $beizhu=input('post.xiaos_beizhu');


        $getval = new Getval();

        if(!$getval->checkkehuid($kehuid)){
            $msg['status'] = 0;
            $msg['msg'] = '客户错误，请检查';
            return json($msg);
            exit();
        }

        if(!$getval->checkjiezhang($riqi)){
            $msg['status'] = 0;
            $msg['msg'] = '本期间已结账，禁止操作';
            return json($msg);
            exit();
        }


        Db::startTrans();
        try {
            $fdata['id'] = $id;
            $fdata['xiaos_xt_id'] = trim(input('xiaos_xt_id'));
            $fdata['xiaos_date'] = trim($riqi);
            $fdata['kehu_id'] = trim($kehuid);
            $fdata['xiaos_cangk_id']=trim($cangkuid);
            $fdata['yuang_id'] = trim($jingsr_id);
            $fdata['xiaos_zhaiy'] = trim($zhaiyao);
            $fdata['user_id'] = session('userid');
            $fdata['zhangt_id'] = session('zhangtao_id');
            $kehuinfo = Db::table('kehu')->where('id', trim($kehuid))->find();
            $fdata['kehu_name'] = $kehuinfo['kehu_name'];
            $fdata['kehu_dizhi'] = $kehuinfo['kehu_dizhi'];
            $fdata['kehu_lianxfs'] = $kehuinfo['kehu_lianxfs'];
            $cangkuinfo = Db::table('cangku')->where('id', trim($cangkuid))->find();
            $fdata['cangk_name'] = $cangkuinfo['cangk_name'];
            $fdata['cangk_lianxfs'] = $cangkuinfo['cangk_lianxfs'];
            $fdata['username'] = Db::table('user')->where('id', session('userid'))->value('username');
            $zhixing=true;
            $xiaoshou=model('xiaoshou');

            $xiaoshou->store($fdata);
            
            $t=0;
            for($i=0;$i<count($wuliaoid);$i++){
                if($wuliaoid[$i]>0 && ($shul[$i] >0 || $shul[$i] <0)){
                    $t++;
                }
                
            }


            if($t==0){
                throw new \Exception('表单不全，请重新输入');
            }

            $ftmp = false;
            if(!Db::table('xiaoshouentry')->where('xiaos_id','=', $id)->delete()){
                throw new \Exception('原明细删除失败');
            }else{
                for($i=0;$i<=$t;$i++){
                    if($wuliaoid[$i]<>''){

                        if(!$getval->checkwuliaoid($wuliaoid[$i])){
                            throw new \Exception('物料错误，请检查');  
                        }
                        
                        $data['xiaos_id'] = trim($id);
                        $data['wuliao_id'] = trim($wuliaoid[$i]);
                        $data['danw_id'] = trim($danwid[$i]);
                        $data['wuliao_name'] = Db::table('wuliao')->where('id', trim($wuliaoid[$i]))->value('wuliao_name');
                        $danweiinfo = Db::table('danwentry')->where('id', trim($danwid[$i]))->find();
                        $data['danw_name'] = $danweiinfo['danw_name'];
                        $data['danw_huans'] = $danweiinfo['danw_huans'];
                        $data['shul'] = trim($shul[$i]);
                        $data['danj'] = round(trim($danj[$i]),2);
                        $data['jine'] = round(trim($shul[$i])*trim($danj[$i]),2);
                        $data['beizhu'] = trim($beizhu[$i]);
                        $xiaosouentry=model('xiaoshouentry');
                        if(!$xiaosouentry->store($data)){
                            throw new \Exception('明细插入失败');
                        }else{
                            $ftmp = true;
                        }
                    }
                }
            }
            if(!$ftmp){
                throw new \Exception('单据明细插入失败');
            }

            Db::commit();
            $msg['status'] = 1;
            $msg['msg'] = $fdata['xiaos_xt_id'];
            return json($msg);
        } catch (\Exception $e) {
            Db::rollback();
            $msg['status'] = 0;
            $msg['msg'] = $e->getMessage();
            return json($msg);
        }
        
    }


    public function xiaos_del(){
        $this->checkquanxian();

        $id = input('post.xiaos_id');
        $xtid = input('post.xiaos_xtid');

        $fdate = Db::table('xiaoshou')->where('id','=',$id)->value('xiaos_date');
        $getval = new Getval();
        if(!$getval->checkjiezhang($fdate)){
            return json('本期间已结账，禁止删除');
            exit();
        }

        $checkshouk = Db::table('shoukuanlist')
            ->where('xiaoshou_id','=',$xtid)
            ->where('zhangt_id', input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id'))
            ->count();

        if($checkshouk>0){
            return json('此单据已被收款引用，禁止删除');
        }


        Db::startTrans();
        try {
            if(!Db::table('xiaoshou')->where('id','=',$id)->delete()){
                throw new \Exception('表单主体删除失败');
            }
            if(!Db::table('xiaoshouentry')->where('xiaos_id','=',$id)->delete()){
                throw new \Exception('表单明细删除失败');
            }

            Db::commit();
            return json($xtid.'--删除成功！');
        } catch (\Exception $e) {
            Db::rollback();
            return json($e->getMessage());
        }
        
    }


    public function xiaosdaochu(){
        $this->checkquanxian();
        
        $ksrq=input('ksrq');
        $jsrq=input('jsrq');
        $kehu=input('kehu');
        $pinzhong = input('pinzhong');
        $beizhu=input('beizhu');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['kehu_name|xiaos_xt_id','like',"%$kehu%"];
        $where[] = ['beizhu','like',"%$beizhu%"];
        $where[] = ['wuliao_name','like',"%$pinzhong%"];

        if($ksrq<>''){
            if($jsrq<>''){
                $where[] = ['xiaos_date', 'between time', [$ksrq, $jsrq]];
            }else{
                $where[] = ['xiaos_date', '=', $ksrq];
            }
        }

        $row = Db::table('xiaoshoulist')
            ->where($where)
            ->order('xiaos_xt_id desc')
            ->select();
        $daochu = new Daochu;
        $daochu->xiaosdaochu($row);
    }


    public function xiaos_print(){
        $id = input('id');
        $row = Db::table('xiaoshoulist')
            ->where('id','=', $id)
            ->select();

        $this->assign('shulheji', 0);
        $this->assign('jineheji', 0);
        $this->assign('row', $row);
        return view('Xiaos/xiaos_print');
    }


}

