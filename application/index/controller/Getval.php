<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\facade\Session;
use Endroid\QrCode\QrCode;


class Getval extends Common{
	public function __construct() {
        parent::__construct();
        if (method_exists($this, '_initialize')) {
		    $this->_initialize();
		}
    }


    public function getkehu(){
        $kehuval = input('post.kehu');
    	$row = Db::table('kehu')
            ->field('id,concat(kehu_name,"-",kehu_dizhi) as name')
            ->where('kehu_name','like',"%$kehuval%")
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        return json($row);
    }

    public function getgongys(){
        $gongysval = input('post.gongys');
        $row = Db::table('gongys')
            ->field('id,concat(gongys_name,"-",gongys_dizhi) as name')
            ->where('gongys_name|id','like',"%$gongysval%")
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        return json($row);
    }


    public function getwuliao(){
        $wuliao_val = input('post.wuliao');
        $row = Db::table('wuliaolist')
            ->where('id|wuliao_name','like',"%$wuliao_val%")
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        return json($row);
    }

    public function getwuliaoentry(){
        $wuliao_id = input('post.wuliaoid');
        $row = Db::table('wuliao')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->find($wuliao_id);
        return json($row);
    }

    public function getwuliaozu(){
        $zuming = input('post.zuming');
        $row = Db::table('wuliaozu')
            ->where('wuliao_zu','like',"%$zuming%")
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        return json($row);
    }

    public function getdanwzu(){
        $zuming = input('post.zuming');
        $row = Db::table('danw')
            ->where('danw_zu','like',"%$zuming%")
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        return json($row);
    }

    public function danwlist(){
        $row = Db::table('danwlist')
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->select();
        return json($row);
    }

    public function getdanwentry(){
        $wuliao_id = input('post.wuliaoid');
        $danw_zu_id = Db::table('wuliao')
            ->where('id',$wuliao_id)
            ->value('danw_zu_id');

        $row = Db::table('danwentry')
            ->where('danw_zu_id','=',$danw_zu_id)
            ->order('danw_huans','desc')
            ->select();
        return json($row);
    }

    public function getcaigou_xt_id($zhangtid = 0){
        $xtid=Db::table('caigou')
            ->where('caig_xt_id','like','%'.date('Ymd').'%')
            ->where('zhangt_id','=', ($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->count();
            
        if($xtid>0){
            $lastid=Db::table('caigou')
                ->where('caig_xt_id','like','%'.date('Ymd').'%')
                ->where('zhangt_id','=', ($zhangtid>0)?$zhangtid:session('zhangtao_id'))
                ->order('caig_xt_id desc')
                ->value('caig_xt_id');
            $xuhao=(int)substr($lastid, 11,4);
            return 'CG_'.date('Ymd').str_pad($xuhao+1,4,"0",STR_PAD_LEFT);
        }else{
            return 'CG_'.date('Ymd').'0001';
        }

    }

    public function getxiaos_xt_id($zhangtid = 0){
        $xtid=Db::table('xiaoshou')
            ->where('xiaos_xt_id','like','%'.date('Ymd').'%')
            ->where('zhangt_id','=', ($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->count();
        if($xtid>0){
            $lastid=Db::table('xiaoshou')
                ->where('xiaos_xt_id','like','%'.date('Ymd').'%')
                ->where('zhangt_id','=', ($zhangtid>0)?$zhangtid:session('zhangtao_id'))
                ->order('xiaos_xt_id desc')
                ->value('xiaos_xt_id');
            $xuhao=(int)substr($lastid, 11,4);
            return 'XS_'.date('Ymd').str_pad($xuhao+1,4,"0",STR_PAD_LEFT);
        }else{
            return 'XS_'.date('Ymd').'0001';
        }

    }

    public function getshouk_xt_id($zhangtid=0){
        $row = Db::table('shoukuan')
            ->where('zhangt_id','=',($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->where('shouk_xt_id','like','%'. date('Ymd') . '%')
            ->order('shouk_xt_id desc')
            ->value('shouk_xt_id');
        if($row != null){
            $xuhao = (int)substr($row, 11,3);
            return 'SK'.date('Ymd').str_pad($xuhao+1,3,"0",STR_PAD_LEFT);
        }else{
            return 'SK' . date('Ymd') . '001';
        }
    }

    public function getfukuan_xt_id($zhangtid=0){
        $row = Db::table('fukuan')
            ->where('zhangt_id','=',($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->where('fukuan_xt_id','like','%'. date('Ymd') . '%')
            ->order('fukuan_xt_id desc')
            ->value('fukuan_xt_id');
        if($row != null){
            $xuhao = (int)substr($row, 11,3);
            return 'FK'.date('Ymd').str_pad($xuhao+1,3,"0",STR_PAD_LEFT);
        }else{
            return 'FK' . date('Ymd') . '001';
        }
    }

    public function getshouzhi_xt_id($zhangtid=0){
        $row = Db::table('qitashouzhi')
            ->where('zhangt_id','=',($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->where('shouz_xt_id','like','%'. date('Ymd') . '%')
            ->order('shouz_xt_id desc')
            ->value('shouz_xt_id');
        if($row != null){
            $xuhao = (int)substr($row, 11,3);
            return 'SZ'.date('Ymd').str_pad($xuhao+1,3,"0",STR_PAD_LEFT);
        }else{
            return 'SZ' . date('Ymd') . '001';
        }
    }

    public function getyuang(){
        $search=input('yuang');
        $row = Db::table('yuangong')
            ->where('yuang|id','like',"%$search%")
            ->where('zhangt_id','=', session('zhangtao_id'))
            ->field('id,yuang as name')
            ->select();
        return json($row);
    }


    public function erweima($size = 100){
        $qrCode=new QrCode();
        $neirong = input('neirong'). '/zhangt_id/' . session('zhangtao_id');//加http://这样扫码可以直接跳转url
        $qrCode->setText($neirong)
            ->setSize($size)//大小
            ->setErrorCorrectionLevel('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabelFontSize(16);
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
        exit();
    }

    public function getkucun(){
        $id = input('wuliaoid');
        $cangkid = input('cangkuid');
        $where[] = ['wuliaoid','=', $id];
        $where[] = ['cangk_id','=', $cangkid];
        $where[] = ['zhangt_id','=', session('zhangtao_id')];
        $row = Db::table('jishikucun')
            ->where($where)
            ->find();
        $max = $this->getwuliao_danw_max($id);
        $max = ($max==0)?1:$max;

        $kucun['wuliao_name'] = $row['wuliao_name'];
        $kucun['jiben'] = $row['jiben'];
        $kucun['changyong'] = round($row['jiben']/$max,2);
        return json($kucun);
    }


    public function getqiank(){
        $kehuid = input('kehuid');
        $shishou = Db::table('shoukuanlist')
            ->where('kehu_id','=', $kehuid)
            ->where('zhangt_id','=', input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id'))
            ->sum('heji');
        $xiaos = Db::table('xiaoshoulist')
            ->where('kehuid','=', $kehuid)
            ->where('zhangt_id','=', input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id'))
            ->sum('jine');
        return $xiaos - $shishou;
    }

    public function getgongysqiank(){
        $gongysid = input('gongysid');
        $fukuan = Db::table('fukuanlist')
            ->where('gongys_id','=', $gongysid)
            ->where('zhangt_id','=', input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id'))
            ->sum('heji');
        $caigou = Db::table('caigoulist')
            ->where('gongysid','=', $gongysid)
            ->where('zhangt_id','=', input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id'))
            ->sum('jine');
        return $caigou - $fukuan;
    }

    public function getbennianval(){
        $year = date('Y');
        $zhangtaoid = session('zhangtao_id');
        $row = Db::query("select month(xiaos_date) as fmonth, sum(jine) as jine from xiaoshoulist where year(xiaos_date)=$year and zhangt_id = $zhangtaoid group by month(xiaos_date)");

        $jinnian = array();

        for($i=0; $i<12; $i++){
            for($r=0;$r<count($row); $r++){
                if($row[$r]['fmonth'] == $i+1){
                    array_push($jinnian, $row[$r]['jine']);
                }
            }

            if(count($jinnian) != $i+1){
                array_push($jinnian, 0);
            }
            
        }

        return json($jinnian);
    }


    public function getqunianval(){
        $lastyear = date('Y')-1;
        $zhangtaoid = session('zhangtao_id');

        $qunian_row = Db::query("select month(xiaos_date) as fmonth, sum(jine) as jine from xiaoshoulist where year(xiaos_date)=$lastyear and zhangt_id = $zhangtaoid group by month(xiaos_date)");
        $qunian = array();
        for($i=0; $i<12; $i++){
            for($r=0; $r<count($qunian_row); $r++){
                if($qunian_row[$r]['fmonth'] == $i+1){
                    array_push($qunian, $qunian_row[$r]['jine']);
                }
            }
            
            if(count($qunian) != $i+1){
                array_push($qunian, 0);
            }
        }
        return json($qunian);
    }

    public function checkjiezhang($fdate,$zhangtid=0){
        $lastyue = Db::table('jiezhang')
            ->where('zhangt_id','=', ($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->order('id desc')
            ->limit(1)
            ->select();

        if(count($lastyue)>0){
            $yuefen = $lastyue[0]['fyear'] . '-' . $lastyue[0]['fmonth'] . '-1';
        }else{
            return true;
        }
        

        $lastdate = date('Y-m-d', strtotime("$yuefen +1 month -1 day"));

        if(strtotime($fdate) > strtotime($lastdate)){
            return true;
        }else{
            return false;
        }
    }

    public function getxiaoshouid(){
        $xiaoshou_id = Db::table('shoukuanlist')
            ->where('zhangt_id','=',input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id'))
            ->where('xiaoshou_id','not NULL')
            ->distinct(true)
            ->column('xiaoshou_id');

        $row = Db::table('xiaoshoulist')
            ->where('zhangt_id','=',input('?zhangt_id')?input('zhangt_id'):session('zhangtao_id'))
            ->where('kehuid','=',input('kehuid'))
            ->where('xiaos_xt_id','like','%' . input('xiaoshouid') . '%')
            ->whereNotIn('xiaos_xt_id', $xiaoshou_id)
            ->field('xiaos_xt_id as name,sum(jine) as heji')
            ->group('xiaos_xt_id')
            ->having('sum(jine)>0')
            ->fetchsql(false)
            ->select();

        return json($row);
    }

    public function getwuliao_danw_max($wuliaoid, $zhangtid=0){
        $danwzuid = Db::table('wuliao')
            ->where('id',$wuliaoid)
            ->where('zhangt_id',($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->value('danw_zu_id');

        $max = Db::table('danwentry')
            ->where('danw_zu_id',$danwzuid)
            ->max('danw_huans');

        return $max;
    }

    public function checkkehuid($id,$zhangtid = 0){
        $row = Db::table('kehu')
            ->where('zhangt_id',($zhangtid != 0)?$zhangtid:session('zhangtao_id'))
            ->where('id',$id)
            ->count();
        if($row > 0){
            return true;
        }else{
            return false;
        }
    }

    public function checkgongysid($id, $zhangtid = 0){
        $row = Db::table('gongys')
            ->where('zhangt_id',($zhangtid > 0)?$zhangtid:session('zhangtao_id'))
            ->where('id',$id)
            ->count();
        if($row > 0){
            return true;
        }else{
            return false;
        }
    }

    public function checkwuliaoid($id, $zhangtid = 0){
        $row = Db::table('wuliao')
            ->where('zhangt_id',($zhangtid>0)?$zhangtid:session('zhangtao_id'))
            ->where('id',$id)
            ->count();
        if($row > 0){
            return true;
        }else{
            return false;
        }
    }

}
