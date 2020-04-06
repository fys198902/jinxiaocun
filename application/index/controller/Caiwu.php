<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;


class Caiwu extends Common{
	public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
		    $this->_initialize();
		}
    }

    public function qitashouzhi(){
        $leibie = Db::table('shoukuanleibie')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();


        $getval = new Getval();
        $this->assign('shouz_xt_id', $getval->getshouzhi_xt_id());
        $this->assign('fdate', date('Y-m-d'));
        $this->assign('leibie', $leibie);
        return view('Caiwu/qitashouzhi');
    }

    public function qitashouzhi_do(){
        $this->checkquanxian();

        $getval = new Getval();
        $fdata['id'] = 0;
        $fdata['shouz_xt_id'] = $getval->getshouzhi_xt_id(input('zhangt_id'));
        $fdata['fdate'] = input('fdate');
        $fdata['zhaiyao'] = input('zhaiyao');
        $fdata['shoukleibie_id'] = input('shoukleibieid');
        $fdata['leibie'] = input('leibie');
        $fdata['jine'] = input('jine');
        $fdata['user_id'] = input('?userid')?input('userid'):session('userid');
        $fdata['zhangt_id'] = input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id');

        $getval = new Getval();
        if(!$getval->checkjiezhang(input('fdate'), input('zhangt_id'))){
            $msg['status'] = 0;
            $msg['msg'] = '此期间已结账，禁止操作';
            return json($msg);
            exit();
        }


        $qitashouzhi = model('qitashouzhi');
        if($qitashouzhi->store($fdata)){
            $msg['status'] = 1;
            $msg['msg'] = $fdata['shouz_xt_id'];
            return json($msg);
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '插入失败';
            return json($msg);
        }
    }


    public function qitashouzhi_list(){
        $yema=20;

        $row = Db::table('qitashouzhilist')
            ->where('shouz_xt_id|zhaiyao','like','%' . input('zhaiyao') . '%')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->order('fdate desc')
            ->paginate($yema);

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
        $this->assign('zhaiyao', input('zhaiyao'));
        return view('Caiwu/qitashouzhi_list');

    }

    public function qitashouzhi_del(){
        $this->checkquanxian();

        if(Db::table('qitashouzhi')->delete(input('id'))){
            $msg['status'] = 1;
            $msg['msg'] = '删除成功';
            return json($msg);
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '删除失败';
            return json($msg);

        }
    }

    public function qitashouzhi_update(){
        $row = Db::table('qitashouzhilist')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->where('id','=',input('id'))
            ->select();
        $this->assign('row', $row);
        return view('Caiwu/qitashouzhi_update');
    }

    public function qitashouzhi_daochu(){
        $this->checkquanxian();

        $daochu = new Daochu;
        $row = Db::table('qitashouzhilist')
            ->where('zhaiyao','like','%' . input('zhaiyao') . '%')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->field('fdate,shouz_xt_id,zhaiyao,case leibie when 0 then "支出" else "收入" end as leibie,jine,username')
            ->select();

        $daochu->qitashouzhidaochu($row);
    }

    public function yuemojiesuan(){
        $this->checkquanxian();
        
        $yuefen = input('yuefen');
        $lastyuef = Db::table('jiezhang')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->order('id desc')->limit(1)->select();

        if(count($lastyuef)>0){
            $lastyue = $lastyuef[0]['fyear'] . '-' . str_pad($lastyuef[0]['fmonth'],2,"0",STR_PAD_LEFT);
        }else{
            $lastyue = "暂无已结账月份";
        }
        
        if($yuefen != ''){
            $first = $yuefen . '-01';
            $last = date('Y-m-d', strtotime("$yuefen +1 month -1 day")); 

            $zhekou = Db::table('shoukuanlist')
                ->where('fdate','between time', [$first,$last])
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->sum('zhekou');

            $qitashouzhi = Db::table('qitashouzhilist')
                ->where('fdate','between time', [$first,$last])
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->field('sum(case leibie when 0 then jine*-1 else jine end) as jine')
                ->select();

            $benyuexiaoshou = Db::table('xiaoshoulist')
                ->where('xiaos_date','between time',[$first,$last])
                ->where('zhangt_id','=',session('zhangtao_id'))
                ->field('wuliaoid,wuliao_name,danw_huans,sum(danw_huans*shul) as jibenshul,sum(jine) as shouru')
                ->group('wuliaoid,wuliao_name,danw_huans')
                ->select();

            $shangyue = date('Y-m-d', strtotime("$yuefen -1 month"));
            
            $shang_year = date('Y',strtotime($shangyue));
            $shang_month = date('m', strtotime($shangyue));


            $jiezhang_id = Db::table('jiezhang')
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->where('fyear','=',$shang_year)
                ->where('fmonth','=',$shang_month)
                ->value('id');

            $shangqi = Db::table('chengbenlist')
                ->where('jiezhang_id','=', $jiezhang_id)
                ->select();

            $where[] = ['caig_date','between time', [$first,$last]];
            $where[] = ['zhangt_id','=', session('zhangtao_id')];
            $benqi = Db::table('caigoulist')
                ->where($where)
                ->field('wuliaoid,wuliao_name,sum(shul*danw_huans) as gourushul,sum(jine) as gourujine')
                ->group('wuliaoid,wuliao_name')
                ->select();

            $ab = 0;
            $benqi_row = [];

            $wuliao = Db::table('wuliaolist')
                ->where('zhangt_id','=', session('zhangtao_id'))
                ->select();


            $ac = 0;
            for($i = 0; $i < count($wuliao); $i++){
                $cunzai = 0;
                for($r = 0;$r < count($benqi); $r++){
                    if($wuliao[$i]['id'] == $benqi[$r]['wuliaoid']){
                        $benqi_row[$ac]['id'] = $wuliao[$i]['id'];
                        $benqi_row[$ac]['wuliao'] = $wuliao[$i]['wuliao_name'];
                        $benqi_row[$ac]['shul'] = $benqi[$r]['gourushul'];
                        $benqi_row[$ac]['jine'] = $benqi[$r]['gourujine'];
                        $ac++;
                        $cunzai = 1;
                        break;
                    }
                }

                if(!$cunzai){
                    $benqi_row[$ac]['id'] = $wuliao[$i]['id'];
                    $benqi_row[$ac]['wuliao'] = $wuliao[$i]['wuliao_name'];
                    $benqi_row[$ac]['shul'] = 0;
                    $benqi_row[$ac]['jine'] = 0;
                    $ac++;
                }
            }


            for($i=0; $i<count($benqi_row); $i++){
                $check=0;
                for($r=0; $r<count($shangqi); $r++){
                    if($benqi_row[$i]['id'] == $shangqi[$r]['wuliaoid']){
                        $row[$ab]['id'] = $benqi_row[$i]['id'];
                        $row[$ab]['wuliao'] = $benqi_row[$i]['wuliao'];
                        $row[$ab]['shul'] = $benqi_row[$i]['shul'] + $shangqi[$r]['shul'];
                        $row[$ab]['jine'] = $benqi_row[$i]['jine'] + $shangqi[$r]['jine'];
                        $check=1;
                        $ab++;
                    }
                }
                if(!$check){
                    $row[$ab]['id'] = $benqi_row[$i]['id'];
                    $row[$ab]['wuliao'] = $benqi_row[$i]['wuliao'];
                    $row[$ab]['shul'] = $benqi_row[$i]['shul'];
                    $row[$ab]['jine'] = $benqi_row[$i]['jine'];
                    $ab++;
                }
            }


            $bow = [];
            $ae = 0;
            for($i=0; $i<count($row); $i++){
                for($r = 0; $r<count($benyuexiaoshou); $r++){
                    if($row[$i]['id'] == $benyuexiaoshou[$r]['wuliaoid']){
                        $bow[$ae]['wuliao'] = $row[$i]['wuliao'];
                        $bow[$ae]['huansuan'] = $benyuexiaoshou[$r]['danw_huans'];
                        $bow[$ae]['jibenshul'] = $benyuexiaoshou[$r]['jibenshul'];

                        if($row[$i]['shul'] ==0){
                            $danwchengb = 0;
                        }else{
                            $danwchengb = round($row[$i]['jine']/$row[$i]['shul'],2);
                        }
                        $bow[$ae]['danwchengb'] = $danwchengb;
                        $bow[$ae]['chengbenjia']  = $benyuexiaoshou[$r]['jibenshul']*$danwchengb;
                        $bow[$ae]['shouru'] = $benyuexiaoshou[$r]['shouru'];
                        $ae++;
                    }
                }
            }


            $statue = 0;
            if(count($lastyuef) == 0 || (substr($yuefen,0,4) > $lastyuef[0]['fyear'] || (substr($yuefen,0,4) == $lastyuef[0]['fyear'] && substr($yuefen,5,2) > $lastyuef[0]['fmonth']))){
                $statue = 1;
            }


            $this->assign('shangqi',$shangqi);
            $this->assign('benqi', $benqi);
            $this->assign('quanbu', $row);
            $this->assign('yuefen', $yuefen);
            $this->assign('statue', $statue);
            $this->assign('lastyue', $lastyue);
            $this->assign('chengben',$bow);
            $this->assign('zongchengben',0);
            $this->assign('zongshouru',0);
            $this->assign('zhekou',$zhekou);
            $this->assign('qitashouzhi',$qitashouzhi);


        }else{
            $this->assign('shangqi',0);
            $this->assign('benqi', 0);
            $this->assign('quanbu', 0);
            $this->assign('yuefen', '');
            $this->assign('statue', 0);
            $this->assign('lastyue', $lastyue);
            $this->assign('chengben','');
            $this->assign('zongchengben',0);
            $this->assign('zongshouru',0);
            $this->assign('zhekou',0);
            $this->assign('qitashouzhi',0);


        }

        if(input('dayin')>0){            
            return view('Caiwu/yuemojiesuan_dayin');
        }else{
            return view('Caiwu/yuemojiesuan');
        }
    }





    public function jiezhang_do(){
        $this->checkquanxian();

        $qijian = input('qijian');
        $id = input('id');
        $shul = input('shul');
        $jine = input('jine');

        $fyear = substr($qijian, 0, 4);
        $fmonth = substr($qijian, 5,2);

        $lastyuef = Db::table('jiezhang')->where('zhangt_id','=', session('zhangtao_id'))->order('id desc')->limit(1)->select();

        if(count($lastyuef)==0 || ($fyear > $lastyuef[0]['fyear'] || ($fyear == $lastyuef[0]['fyear'] && $fmonth > $lastyuef[0]['fmonth']))){
            Db::startTrans();
            try {
                $jiezhang = model('jiezhang');
                $fdata['fyear'] = $fyear;
                $fdata['fmonth'] = $fmonth;
                $fdata['user_id'] = session('userid');
                $fdata['zhangt_id'] = session('zhangtao_id');
                $jiezhang_id = $jiezhang->store($fdata);
                if($jiezhang_id > 0){
                    $chengben = model('chengben');
                    for($i=0; $i< count($id); $i++){
                        $fdata1['jiezhang_id'] = $jiezhang_id;
                        $fdata1['wuliaoid'] = $id[$i];
                        $fdata1['shul'] = $shul[$i];
                        $fdata1['jine'] = $jine[$i];
                        if(!$chengben->store($fdata1)){
                            throw new \Exception('结账第<2>步失败！');
                        }
                    }
                }else{
                    throw new \Exception('结账第<1>步失败！');
                }
                
                Db::commit();
                $msg['status'] = 1;
                $msg['msg'] = $qijian . '已结账';
                return json($msg);
            } catch (\Exception $e) {
                Db::rollback();
                $msg['status'] = 0;
                $msg['msg'] = $e->getMessage();
                return json($msg);
            }
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '此月份已结账';
            return json($msg);
        }
    }

    public function fanjiezhang_do(){
        $this->checkquanxian();
        
        $yuefen = input('qijian');
        $fyear = substr($yuefen, 0, 4);
        $fmonth = substr($yuefen, 5,2);

        if($yuefen != ''){
            $where[] = ['fyear', '=', $fyear];
            $where[] = ['fmonth', '=', $fmonth];
            $where[] = ['zhangt_id', '=', session('zhangtao_id')];
            $jiezhang = Db::table('jiezhang')->where($where)->select();
            
            if(count($jiezhang)>0){
                $jiezhang_id = $jiezhang[0]['id'];
                Db::startTrans();
                try {
                    if(Db::table('jiezhang')->delete($jiezhang_id) && Db::table('chengben')->where('jiezhang_id','=',$jiezhang_id)->delete()){
                    }else{
                        throw new \Exception($yuefen . ' 反结账《失败》');
                    }
                    Db::commit();
                } catch (\Exception $e) {
                    Db::rollback();
                    return json($e->getMessage());
                }
                $msg['status'] = 1;
                $msg['msg'] = $yuefen . ' 反结账成功';
                return json($msg);
            }else{
                $msg['status'] = 0;
                $msg['msg'] = '反结账失败';
                return json($msg);

            }
            
        }else{
            $msg['status'] = 0;
            $msg['msg'] = '反结账失败';
            return json($msg);
        }  
    }

    public function rijizhang(){
        $ksrq = input('ksrq');
        $jsrq = input('jsrq');
        $leibie = input('leibie');
        if(input('ksrq')==''){
            $ksrq = date('Y-m-01', strtotime(date("Y-m-d")));
            $jsrq = date('Y-m-d', strtotime("$ksrq +1 month -1 day"));
        }

        $row = Db::table('shoukuanleibie')
            ->where('zhangt_id','=',session('zhangtao_id'))
            ->select();

        if($leibie == ''){
            $leibie = $row[0]['shoukleibie'];
        }

        // echo Db::table('rijizhang')
        //     ->where('zhangt_id', '=', session('zhangtao_id'))
        //     ->where('fdate','<', $ksrq)
        //     ->where('shoukleibie',$leibie)
        //     ->fetchsql(false)
        //     ->sum('jine');
        $qichu = Db::table('rijizhang')
            ->where('zhangt_id', '=', session('zhangtao_id'))
            ->where('fdate','<', $ksrq)
            ->where('shoukleibie',$leibie)
            ->sum('jine');
        $qimo = Db::table('rijizhang')
            ->where('zhangt_id', '=', session('zhangtao_id'))
            ->where('fdate','<=', $jsrq)
            ->where('shoukleibie',$leibie)
            ->sum('jine');

        $where[] = ['fdate','between time',[$ksrq,$jsrq]];
        $qijian = Db::table('rijizhang')
            ->where('zhangt_id', '=', session('zhangtao_id'))
            ->where($where)
            ->where('shoukleibie',$leibie)
            ->select();
        $this->assign('qichu', $qichu);
        $this->assign('qimo', $qimo);
        $this->assign('qijian', $qijian);
        $this->assign('leibie', $leibie);
        $this->assign('yue',0);
        $this->assign('row', $row);
        $this->assign('ksrq', $ksrq);
        $this->assign('jsrq', $jsrq);
        return view('Caiwu/rijizhang');
    }

}
