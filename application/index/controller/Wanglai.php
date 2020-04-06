<?php
namespace app\index\controller;
use think\Db;
use think\facade\Session;


class Wanglai extends Common{
    public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
            $this->_initialize();
        }
    }

    public function shoukuan(){
        $getval = new Getval();
        $leibie = Db::table('shoukuanleibie')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();

        $this->assign('leibie', $leibie);
        $this->assign('shouk_xt_id', $getval->getshouk_xt_id());
        $this->assign('fdate', date('Y-m-d'));
        return view('Wanglai/shoukuan');
    }

    public function shoukuan_do(){
        $this->checkquanxian();

        $fdata['id'] = 0;
        $fdata['fdate'] = input('fdate');
        $fdata['kehu_id'] = input('kehuid');
        $fdata['zhaiyao'] = input('zhaiyao');
        $fdata['shoukleibie_id'] = input('shoukleibieid');
        $fdata['shishou'] = input('shishou');
        $fdata['zhekou'] = input('?zhekou')?input('zhekou'):0;
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id']= input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');
        $getval = new Getval();
        $fdata['shouk_xt_id'] = $getval->getshouk_xt_id(input('zhangt_id'));
        $danjuid = input('danjuid');


        $getval = new Getval();
        if(!$getval->checkjiezhang(input('fdate'), input('zhangt_id'))){
            $msg['status'] = 0;
            $msg['msg'] = '本期间已结账，禁止操作';
            return json($msg);
            exit();
        }

        if(input('shishou') == 0 && input('zhekou') == 0){
            $msg['status'] = 0;
            $msg['msg'] = '实收金额和折扣金额不得同时为0';
            return json($msg);
        }
        

        Db::startTrans();
        try {
            $shoukuan = model('shoukuan');
            $shoukuanid = $shoukuan->store($fdata);
            if(!$shoukuanid){
                throw new \Exception('插入失败'); 
            }

            if(is_array($danjuid)){
                $fdata1['shouk_id'] = $shoukuanid;
                for($i=0; $i<count($danjuid); $i++){
                    $fdata1['xiaoshou_id'] = $danjuid[$i];
                    if(!Db::name('shoukuanentry')->insert($fdata1)){
                        throw new \Exception('销售单据ID插入失败');
                    }
                }
            }
            
            Db::commit();
            $msg['status'] = 1;
            $msg['msg'] = $fdata['shouk_xt_id'];
            return json($msg);
        } catch (\Exception $e) {
            Db::rollback();
            $msg['status'] = 0;
            $msg['msg'] = $e->getMessage();
            return json($msg);
        }
    }

    public function shoukuan_list(){
        $kehu = input('kehu');
        $zhaiyao = input('zhaiyao');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['kehu_name|shouk_xt_id|xiaoshou_id','like',"%$kehu%"];
        $where[] = ['zhaiyao','like',"%$zhaiyao%"];

        $yema=20;
        $row = Db::table('shoukuanlist')->where($where)->order('id desc')->paginate($yema);
        $yemas = ceil($row->total()/$yema);


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
        $this->assign('xiayiye',($page+1>$yemas)?$yemas:$page+1);
        $this->assign('kehu', $kehu);
        $this->assign('zhaiyao', $zhaiyao);

        return view('Wanglai/shoukuan_list');
    }

    public function shoukuan_del(){
        $this->checkquanxian();

        Db::startTrans();
        try {
            if(!Db::table('shoukuan')->delete(input('id'))){
                throw new \Exception('收款单主体删除失败');
            }

            if(Db::table('shoukuanentry')->where('shouk_id','=',input('id'))->count()>0){
                if(!Db::table('shoukuanentry')->where('shouk_id','=',input('id'))->delete()){
                    throw new \Exception('收款单明细删除失败'); 
                }
            }
            
            Db::commit();
            return json('删除成功');
        } catch (\Exception $e) {
            Db::rollback();
            return json($e->getMessage());
        }
    }

    public function kehuduizd(){
        $ksrq = input('ksrq');
        $jsrq = input('jsrq');
        $kehu = input('kehu');
        $kehuid = input('kehuid');

        if($kehuid != ''){
            $where1[] = ['fdate','>=', $ksrq];
            $where1[] = ['fdate','<=', $jsrq];
            $where1[] = ['kehu_id','=', $kehuid];
            $where1[] = ['zhangt_id','=', session('zhangtao_id')];
            $shoukzhek = Db::table('shoukuanlist')->where($where1)->select();


            $where2[] = ['xiaos_date','>=', $ksrq];
            $where2[] = ['xiaos_date','<=', $jsrq];
            $where2[] = ['kehuid','=', $kehuid];
            $where2[] = ['zhangt_id','=', session('zhangtao_id')];
            $xiaos = Db::table('xiaoshoulist')->where($where2)->select();

            $qianq_shoukzhek = Db::table('shoukuanlist')
                ->where('kehu_id','=',$kehuid)
                ->where('fdate','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('heji');

            $qianq_xiaose = Db::table('xiaoshoulist')
                ->where('kehuid','=',$kehuid)
                ->where('xiaos_date','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('jine');

            $qichu = $qianq_xiaose - $qianq_shoukzhek;

            $benqi_shishou = Db::table('shoukuanlist')->where($where1)->sum('shishou');
            $benqi_zhekou = Db::table('shoukuanlist')->where($where1)->sum('zhekou');
            $benqi_xiaos = Db::table('xiaoshoulist')->where($where2)->sum('jine');

            $benqi_xiaosgoum = Db::table('xiaoshoulist')
                ->where($where2)
                ->where('danj','<>', 0)
                ->field('wuliao_name,danw_name,sum(shul) as xiaol')
                ->group('wuliao_name,danw_name')
                ->select();
            $benqi_xiaoszengs = Db::table('xiaoshoulist')
                ->where($where2)
                ->where('danj','=', 0)
                ->field('wuliao_name,danw_name,sum(shul) as xiaol')
                ->group('wuliao_name,danw_name')
                ->select();
            $this->assign('xiaosgroup_goum', $benqi_xiaosgoum);
            $this->assign('xiaosgroup_zengs', $benqi_xiaoszengs);
            $this->assign('ksrq', $ksrq);
            $this->assign('jsrq', $jsrq);
            $this->assign('kehu', $kehu);
            $this->assign('kehuid', $kehuid);
            $this->assign('qichu', $qichu);
            $this->assign('benqi_shishou', $benqi_shishou);
            $this->assign('benqi_zhekou', $benqi_zhekou);
            $this->assign('benqi_xiaos', $benqi_xiaos);
            $this->assign('shishou_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('xiaos_shul', 0);
            $this->assign('xiaos_jine', 0);
            $this->assign('xiaoslist', $xiaos);
            $this->assign('shoukzhek', $shoukzhek);
            $this->assign('fdate', date('Y-m-d H:i:s'));
        }else{
            $this->assign('xiaosgroup_goum', '');
            $this->assign('xiaosgroup_zengs', '');
            $this->assign('ksrq', '');
            $this->assign('jsrq', '');
            $this->assign('kehu', '');
            $this->assign('kehuid', '');
            $this->assign('qichu', 0);
            $this->assign('benqi_shishou', 0);
            $this->assign('benqi_zhekou', 0);
            $this->assign('benqi_xiaos', 0);
            $this->assign('shishou_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('xiaos_shul', 0);
            $this->assign('xiaos_jine', 0);
            $this->assign('xiaoslist', '');
            $this->assign('shoukzhek', '');
            $this->assign('fdate', date('Y-m-d H:i:s'));
        }
        

        return view('Wanglai/kehuduizd');
    }


    public function kehu_duizhangd_dayin(){
        $ksrq = input('ksrq');
        $jsrq = input('jsrq');
        $kehu = input('kehu');
        $kehuid = input('kehuid');

        if($kehuid != ''){
            $where1[] = ['fdate','>=', $ksrq];
            $where1[] = ['fdate','<=', $jsrq];
            $where1[] = ['kehu_id','=', $kehuid];
            $where1[] = ['zhangt_id','=', session('zhangtao_id')];
            $shoukzhek = Db::table('shoukuanlist')->where($where1)->select();


            $where2[] = ['xiaos_date','>=', $ksrq];
            $where2[] = ['xiaos_date','<=', $jsrq];
            $where2[] = ['kehuid','=', $kehuid];
            $where2[] = ['zhangt_id','=', session('zhangtao_id')];
            $xiaos = Db::table('xiaoshoulist')->where($where2)->select();

            $qianq_shoukzhek = Db::table('shoukuanlist')
                ->where('kehu_id','=',$kehuid)
                ->where('fdate','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('heji');

            $qianq_xiaose = Db::table('xiaoshoulist')
                ->where('kehuid','=',$kehuid)
                ->where('xiaos_date','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('jine');

            $qichu = $qianq_xiaose - $qianq_shoukzhek;

            $benqi_shishou = Db::table('shoukuanlist')->where($where1)->sum('shishou');
            $benqi_zhekou = Db::table('shoukuanlist')->where($where1)->sum('zhekou');
            $benqi_xiaos = Db::table('xiaoshoulist')->where($where2)->sum('jine');


            $this->assign('ksrq', $ksrq);
            $this->assign('jsrq', $jsrq);
            $this->assign('kehu', $kehu);
            $this->assign('kehuid', $kehuid);
            $this->assign('qichu', $qichu);
            $this->assign('benqi_shishou', $benqi_shishou);
            $this->assign('benqi_zhekou', $benqi_zhekou);
            $this->assign('benqi_xiaos', $benqi_xiaos);
            $this->assign('shishou_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('xiaos_shul', 0);
            $this->assign('xiaos_jine', 0);
            $this->assign('xiaoslist', $xiaos);
            $this->assign('shoukzhek', $shoukzhek);
        }else{
            $this->assign('ksrq', '');
            $this->assign('jsrq', '');
            $this->assign('kehu', '');
            $this->assign('kehuid', '');
            $this->assign('qichu', 0);
            $this->assign('benqi_shishou', 0);
            $this->assign('benqi_zhekou', 0);
            $this->assign('benqi_xiaos', 0);
            $this->assign('shishou_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('xiaos_shul', 0);
            $this->assign('xiaos_jine', 0);
            $this->assign('xiaoslist', '');
            $this->assign('shoukzhek', '');
        }
        

        return view('Wanglai/kehu_duizhangd_dayin');
    }

    public function shoukuan_daochu(){
        $this->checkquanxian();

        $kehu = input('kehu');
        $zhaiyao = input('zhaiyao');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['kehu_name|shouk_xt_id','like',"%$kehu%"];
        $where[] = ['zhaiyao','like',"%$zhaiyao%"];

        $row = Db::table('shoukuanlist')->where($where)->select();
        $this->assign('row', $row);
        $daochu = new Daochu;
        $daochu->shoukuandaochu($row);
    }


    public function fukuandan(){
        $getval = new Getval();
        $leibie = Db::table('shoukuanleibie')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();

        $this->assign('fukuan_xt_id', $getval->getfukuan_xt_id());
        $this->assign('fdate', date('Y-m-d'));
        $this->assign('leibie', $leibie);
        return view('Wanglai/fukuandan');

    }

    public function fukuandan_do(){
        $this->checkquanxian();

        $getval = new Getval();
        $fdata['id'] = 0;
        $fdata['fukuan_xt_id'] = $getval->getfukuan_xt_id(input('zhangt_id'));
        $fdata['fdate'] = input('fdate');
        $fdata['gongys_id'] = input('gongysid');
        $fdata['zhaiyao'] = input('zhaiyao');
        $fdata['shoukleibie_id'] = input('shoukleibieid');
        $fdata['shifu'] = input('shifu');
        $fdata['zhekou'] = input('zhekou');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');

        $getval = new Getval();
        if(!$getval->checkjiezhang(input('fdate'), input('zhangt_id'))){
            $msg['status'] = 0;
            $msg['msg'] = '本期间已结账，禁止操作';
            return json($msg);
            exit();
        }

        if(input('shifu') == 0 && input('zhekou') == 0){
            $msg['status'] = 0;
            $msg['msg'] = '实付金额和折扣金额不得同时为0';
            return json($msg);
        }


        $fukuan = model('fukuan');
        if($fukuan->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = $fdata['fukuan_xt_id'];
            return json($msg);
        }
    }


    public function fukuandan_list(){
        $gongys = input('gongys');
        $zhaiyao = input('zhaiyao');

        $where[] = ['zhangt_id','=',session('zhangtao_id')];
        $where[] = ['gongys_name|fukuan_xt_id','like',"%$gongys%"];
        $where[] = ['zhaiyao','like',"%$zhaiyao%"];

        $yema=20;
        $row = Db::table('fukuanlist')->where($where)->order('id desc')->paginate($yema);
        $yemas = ceil($row->total()/$yema);

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
        $this->assign('xiayiye',($page+1>$yemas)?$yemas:$page+1);
        $this->assign('gongys', $gongys);
        $this->assign('zhaiyao', $zhaiyao);

        return view('Wanglai/fukuandan_list');
    }


    public function fukuan_del(){
        $this->checkquanxian();

        if(Db::table('fukuan')->delete(input('id'))){
            return json('删除成功');
        }else{
            return json('删除失败');
        }
    }


    public function gongysduizd(){
        $ksrq = input('ksrq');
        $jsrq = input('jsrq');
        $gongys = input('gongys');
        $gongysid = input('gongysid');

        if($gongysid != ''){
            $where1[] = ['fdate','>=', $ksrq];
            $where1[] = ['fdate','<=', $jsrq];
            $where1[] = ['gongys_id','=', $gongysid];
            $where1[] = ['zhangt_id','=', session('zhangtao_id')];
            $fukuanzhek = Db::table('fukuanlist')->where($where1)->select();


            $where2[] = ['caig_date','>=', $ksrq];
            $where2[] = ['caig_date','<=', $jsrq];
            $where2[] = ['gongysid','=', $gongysid];
            $where2[] = ['zhangt_id','=', session('zhangtao_id')];
            $caigou = Db::table('caigoulist')->where($where2)->select();

            $qianq_fukuanzhek = Db::table('fukuanlist')
                ->where('gongys_id','=',$gongysid)
                ->where('fdate','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('heji');

            $qianq_caigoue = Db::table('caigoulist')
                ->where('gongysid','=',$gongysid)
                ->where('caig_date','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('jine');

            $qichu = $qianq_caigoue - $qianq_fukuanzhek;

            $benqi_fukuan = Db::table('fukuanlist')->where($where1)->sum('shifu');
            $benqi_zhekou = Db::table('fukuanlist')->where($where1)->sum('zhekou');
            $benqi_caigou = Db::table('caigoulist')->where($where2)->sum('jine');


            $this->assign('ksrq', $ksrq);
            $this->assign('jsrq', $jsrq);
            $this->assign('gongys', $gongys);
            $this->assign('gongysid', $gongysid);
            $this->assign('qichu', $qichu);
            $this->assign('benqi_fukuan', $benqi_fukuan);
            $this->assign('benqi_zhekou', $benqi_zhekou);
            $this->assign('benqi_caigou', $benqi_caigou);
            $this->assign('shifu_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('caigou_shul', 0);
            $this->assign('caigou_jine', 0);
            $this->assign('caigoulist', $caigou);
            $this->assign('fukuanzhek', $fukuanzhek);
        }else{
            $this->assign('ksrq', '');
            $this->assign('jsrq', '');
            $this->assign('gongys', '');
            $this->assign('gongysid', '');
            $this->assign('qichu', 0);
            $this->assign('benqi_fukuan', 0);
            $this->assign('benqi_zhekou', 0);
            $this->assign('benqi_caigou', 0);
            $this->assign('shifu_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('caigou_shul', 0);
            $this->assign('caigou_jine', 0);
            $this->assign('caigoulist', '');
            $this->assign('fukuanzhek', '');
        }
        

        return view('Wanglai/gongysduizd');
    }


    public function gongys_duizhangd_dayin(){
        $ksrq = input('ksrq');
        $jsrq = input('jsrq');
        $gongys = input('gongys');
        $gongysid = input('gongysid');

        if($gongysid != ''){
            $where1[] = ['fdate','>=', $ksrq];
            $where1[] = ['fdate','<=', $jsrq];
            $where1[] = ['gongys_id','=', $gongysid];
            $where1[] = ['zhangt_id','=', session('zhangtao_id')];
            $fukuanzhek = Db::table('fukuanlist')->where($where1)->select();


            $where2[] = ['caig_date','>=', $ksrq];
            $where2[] = ['caig_date','<=', $jsrq];
            $where2[] = ['gongysid','=', $gongysid];
            $where2[] = ['zhangt_id','=', session('zhangtao_id')];
            $caigou = Db::table('caigoulist')->where($where2)->select();

            $qianq_fukuanzhek = Db::table('fukuanlist')
                ->where('gongys_id','=',$gongysid)
                ->where('fdate','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('heji');

            $qianq_caigoue = Db::table('caigoulist')
                ->where('gongysid','=',$gongysid)
                ->where('caig_date','<',$ksrq)
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('jine');

            $qichu = $qianq_caigoue - $qianq_fukuanzhek;

            $benqi_fukuan = Db::table('fukuanlist')->where($where1)->sum('shifu');
            $benqi_zhekou = Db::table('fukuanlist')->where($where1)->sum('zhekou');
            $benqi_caigou = Db::table('caigoulist')->where($where2)->sum('jine');


            $this->assign('ksrq', $ksrq);
            $this->assign('jsrq', $jsrq);
            $this->assign('gongys', $gongys);
            $this->assign('gongysid', $gongysid);
            $this->assign('qichu', $qichu);
            $this->assign('benqi_fukuan', $benqi_fukuan);
            $this->assign('benqi_zhekou', $benqi_zhekou);
            $this->assign('benqi_caigou', $benqi_caigou);
            $this->assign('shifu_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('caigou_shul', 0);
            $this->assign('caigou_jine', 0);
            $this->assign('caigoulist', $caigou);
            $this->assign('fukuanzhek', $fukuanzhek);
        }else{
            $this->assign('ksrq', '');
            $this->assign('jsrq', '');
            $this->assign('gongys', '');
            $this->assign('gongysid', '');
            $this->assign('qichu', 0);
            $this->assign('benqi_fukuan', 0);
            $this->assign('benqi_zhekou', 0);
            $this->assign('benqi_caigou', 0);
            $this->assign('shifu_hej', 0);
            $this->assign('zhekou_hej', 0);
            $this->assign('caigou_shul', 0);
            $this->assign('caigou_jine', 0);
            $this->assign('caigoulist', '');
            $this->assign('fukuanzhek', '');
        }
        

        return view('Wanglai/gongys_duizhangd_dayin');
    }

    public function fukuan_update(){
        $row = Db::table('fukuanlist')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->where('id','=', input('id'))
            ->select();
        $this->assign('row',$row);
        return view('Wanglai/fukuan_update');
    }


    public function fukuan_daochu(){
        $this->checkquanxian();

        $gongys = input('gongys');
        $zhaiyao = input('zhaiyao');

        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $where[] = ['gongys_name|fukuan_xt_id','like',"%$gongys%"];
        $where[] = ['zhaiyao','like',"%$zhaiyao%"];

        $row = Db::table('fukuanlist')->where($where)->select();
        $daochu = new Daochu;
        $daochu->fukuandandaochu($row);
    }


    public function shoukuan_update(){        
        $id = input('id');
        $row = Db::table('shoukuanlist')
            ->where('id','=',$id)
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();

        $xiaoshouid = [];
        for($i=0; $i<count($row); $i++){
            if($row[$i]['xiaoshou_id'] !=''){
                array_push($xiaoshouid, $row[$i]['xiaoshou_id']);
            }
        }

        $xiaoshoulist = Db::table('xiaoshoulist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->where('xiaos_xt_id', 'in', $xiaoshouid)
            ->select();

        $this->assign('row', $row);
        $this->assign('xiaoshoulist', $xiaoshoulist);
        return view('Wanglai/shoukuan_update');
    }


    public function kehuqiank(){
        $this->checkquanxian();

        $fashenge = Db::table('xiaoshoulist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('kehuid as id,kehu_name,kehu_dizhi,sum(jine) as fashenge')
            ->group('kehuid,kehu_name,kehu_dizhi')
            ->select();

        $wanglai = Db::table('shoukuanlist')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('kehu_id as id,kehu_name,kehu_dizhi,sum(shishou+zhekou) as heji')
            ->group('kehu_id,kehu_name,kehu_dizhi')
            ->select();

        $row = Db::table('kehu')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('id,kehu_name,kehu_dizhi, 0 as qiank')
            ->select();

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($fashenge); $r++){
                if($row[$i]['id'] == $fashenge[$r]['id']){
                    $row[$i]['qiank'] = $fashenge[$r]['fashenge'];
                    break;
                }
            }
        }

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($wanglai); $r++){
                if($row[$i]['id'] == $wanglai[$r]['id']){
                    $row[$i]['qiank'] = $row[$i]['qiank'] - $wanglai[$r]['heji'];
                    break;
                }
            }
        }

        $this->assign('row', $row);
        $this->assign('heji', 0);
        if(input('print')>0){
            $this->assign('print_date', date('Y-m-d H:i:s'));
            return view('Wanglai/kehuqiank_print'); 
        }else{
            return view('Wanglai/kehuqiank');
        }
    }

    public function kehuqiank_daochu(){
        $this->checkquanxian();

        $fashenge = Db::table('xiaoshoulist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('kehuid as id,kehu_name,kehu_dizhi,sum(jine) as fashenge')
            ->group('kehuid,kehu_name,kehu_dizhi')
            ->select();

        $wanglai = Db::table('shoukuanlist')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('kehu_id as id,kehu_name,kehu_dizhi,sum(shishou+zhekou) as heji')
            ->group('kehu_id,kehu_name,kehu_dizhi')
            ->select();

        $row = Db::table('kehu')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('id,kehu_name,kehu_dizhi, 0 as qiank')
            ->select();

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($fashenge); $r++){
                if($row[$i]['id'] == $fashenge[$r]['id']){
                    $row[$i]['qiank'] = $fashenge[$r]['fashenge'];
                    break;
                }
            }
        }

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($wanglai); $r++){
                if($row[$i]['id'] == $wanglai[$r]['id']){
                    $row[$i]['qiank'] = $row[$i]['qiank'] - $wanglai[$r]['heji'];
                    break;
                }
            }
        }

        $daochu = new daochu;
        $daochu->kehuqiankdaochu($row);
    }


    public function gongysqiank(){
        $this->checkquanxian();

        $fashenge = Db::table('caigoulist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('gongysid as id,gongys_name,gongys_dizhi,sum(jine) as fashenge')
            ->group('gongysid,gongys_name,gongys_dizhi')
            ->select();

        $wanglai = Db::table('fukuanlist')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('gongys_id as id,gongys_name,gongys_dizhi,sum(shifu+zhekou) as heji')
            ->group('gongys_id,gongys_name,gongys_dizhi')
            ->select();

        $row = Db::table('gongys')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('id,gongys_name,gongys_dizhi, 0 as qiank')
            ->select();

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($fashenge); $r++){
                if($row[$i]['id'] == $fashenge[$r]['id']){
                    $row[$i]['qiank'] = $fashenge[$r]['fashenge'];
                    break;
                }
            }
        }

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($wanglai); $r++){
                if($row[$i]['id'] == $wanglai[$r]['id']){
                    $row[$i]['qiank'] = $row[$i]['qiank'] - $wanglai[$r]['heji'];
                    break;
                }
            }
        }

        $this->assign('row', $row);
        $this->assign('heji', 0);
        if(input('print')>0){
            $this->assign('print_date', date('Y-m-d H:i:s'));
            return view('Wanglai/gongysqiank_print'); 
        }else{
            return view('Wanglai/gongysqiank');
        }
    }

    public function gongysqiank_daochu(){
        $this->checkquanxian();
        
        $fashenge = Db::table('caigoulist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('gongysid as id,gongys_name,gongys_dizhi,sum(jine) as fashenge')
            ->group('gongysid,gongys_name,gongys_dizhi')
            ->select();

        $wanglai = Db::table('fukuanlist')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('gongys_id as id,gongys_name,gongys_dizhi,sum(shifu+zhekou) as heji')
            ->group('gongys_id,gongys_name,gongys_dizhi')
            ->select();

        $row = Db::table('gongys')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('id,gongys_name,gongys_dizhi, 0 as qiank')
            ->select();

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($fashenge); $r++){
                if($row[$i]['id'] == $fashenge[$r]['id']){
                    $row[$i]['qiank'] = $fashenge[$r]['fashenge'];
                    break;
                }
            }
        }

        for($i=0; $i< count($row); $i++){
            for($r=0; $r<count($wanglai); $r++){
                if($row[$i]['id'] == $wanglai[$r]['id']){
                    $row[$i]['qiank'] = $row[$i]['qiank'] - $wanglai[$r]['heji'];
                    break;
                }
            }
        }

        $daochu = new daochu;
        $daochu->gongysqiankdaochu($row);
    }
}
