<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;


class Cangchu extends Common{
	public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
		    $this->_initialize();
		}
    }


    public function jishi(){
        $fdate = input('?fdate')?input('fdate'):date('Y-m-d');

        $row = Db::table('taizhang')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->where('fdate','<=',$fdate)
            ->where('wuliao_name', 'not null')
            ->field('wuliaoid,wuliao_name,cangk_id,cangk_name,sum(shul) as jiben')
            ->group('wuliaoid,wuliao_name,cangk_id,cangk_name')
            ->select();

        $getval = new Getval;

        $jishi = [];
        for($i=0; $i < count($row); $i++){
            $jishi[$i]['cangk_name'] = $row[$i]['cangk_name'];
            $jishi[$i]['wuliao_name'] = $row[$i]['wuliao_name'];
            $jishi[$i]['huansuan'] = $getval->getwuliao_danw_max($row[$i]['wuliaoid']);
            $jishi[$i]['jiben'] = $row[$i]['jiben'];
        }
    	
        $this->assign('fdate', $fdate);
    	$this->assign('row', $jishi);
        if(input('print') > 0){
            return view('Cangchu/jishi_print');
        }else{
            return view('Cangchu/jishi');
        }
    	
    }


    public function taizhang(){
        $ksrq = input('ksrq');
        $jsrq = input('jsrq');
        $pinzhong = input('pinzhong');
        $cangku = input('cangk');

        $pinz = Db::table('wuliaolist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('wuliao_name')
            ->select();
        $cangk = Db::table('cangku')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('cangk_name')->select();


        if(input('ksrq')==''){
            $ksrq = date('Y-m-01', strtotime(date("Y-m-d")));
            $jsrq = date('Y-m-d', strtotime("$ksrq +1 month -1 day"));
        }

        if(input('pinzhong') == ''){
            $pinzhong = $pinz[0]['wuliao_name'];
            $cangku = $cangk[0]['cangk_name'];
        }

        $where[] = ['fdate','between time',[$ksrq,$jsrq]];

        $row = Db::table('taizhang')
            ->where($where)
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->where('wuliao_name','=',$pinzhong)
            ->where('cangk_name','=',$cangku)
            ->order('fdate,leibie desc,bianhao')->select();

        $getval = new Getval();
        $max = ($row == null)?1:$getval->getwuliao_danw_max($row[0]['wuliaoid']);

        $kucun = [];

        for($i=0; $i<count($row); $i++){
            $kucun[$i]['fdate'] = $row[$i]['fdate'];
            $kucun[$i]['leibie'] = $row[$i]['leibie'];
            $kucun[$i]['bianhao'] = $row[$i]['bianhao'];
            $kucun[$i]['xiangmu'] = $row[$i]['xiangmu'];
            $kucun[$i]['wuliao_name'] = $row[$i]['wuliao_name'];
            $kucun[$i]['shul'] = $row[$i]['shul'];
            $kucun[$i]['username'] = $row[$i]['username'];
            $kucun[$i]['changyong'] = round($row[$i]['shul']/$max,2);
        }

        $qichu = Db::table('taizhang')
            ->where('fdate','<',$ksrq)
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->where('wuliao_name','=',$pinzhong)
            ->where('cangk_name','=',$cangku)
            ->sum('shul');

        $qimo = Db::table('taizhang')
            ->where('fdate','<=',$jsrq)
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->where('wuliao_name','=',$pinzhong)
            ->where('cangk_name','=',$cangku)
            ->sum('shul');
        

        $this->assign('qichu', $qichu);
        $this->assign('qichu_cy', round($qichu/$max,2));
        $this->assign('qimo', $qimo);
        $this->assign('qimo_cy', round($qimo/$max,2));
        $this->assign('pinzhong', $pinz);
        $this->assign('row', $kucun);
        $this->assign('ksrq', $ksrq);
        $this->assign('jsrq', $jsrq);
        $this->assign('cangk', $cangk);

        $this->assign('pinz_val', $pinzhong);
        $this->assign('cangk_val',$cangku);

        return view('Cangchu/taizhang');
    }

}
