<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
include_once 'vendor/PHPExcel/Classes/PHPExcel.php';
include_once 'vendor/PHPExcel/Classes/PHPExcel/Writer/Excel5.php';

class Daochu extends Common{
	

    public function caigoudaochu($data){
    	$objPHPExcel = new \PHPExcel();
    	$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);

    	$objPHPExcel->getActiveSheet()->setCellValue('A1', '单据编号');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', '单据日期');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', '供应商');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', '单据摘要');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '仓库');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '物料组');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', '物料名称');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', '单位');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', '换算率');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', '数量');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', '单价');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', '金额');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', '备注');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '制单人');


    	foreach ($data as $key => $value) {
    		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['caig_xt_id']);
    		$objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['caig_date']);
    		$objPHPExcel->getActiveSheet()->setCellValue('C' . ($key+2), $value['gongys_name']);
    		$objPHPExcel->getActiveSheet()->setCellValue('D' . ($key+2), $value['caig_zhaiy']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($key+2), $value['cangk_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($key+2), $value['wuliao_zu']);
    		$objPHPExcel->getActiveSheet()->setCellValue('G' . ($key+2), $value['wuliao_name']);
    		$objPHPExcel->getActiveSheet()->setCellValue('H' . ($key+2), $value['danw_name']);
    		$objPHPExcel->getActiveSheet()->setCellValue('I' . ($key+2), $value['danw_huans']);
    		$objPHPExcel->getActiveSheet()->setCellValue('J' . ($key+2), $value['shul']);
    		$objPHPExcel->getActiveSheet()->setCellValue('K' . ($key+2), $value['danj']);
    		$objPHPExcel->getActiveSheet()->setCellValue('L' . ($key+2), $value['jine']);
    		$objPHPExcel->getActiveSheet()->setCellValue('M' . ($key+2), $value['beizhu']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . ($key+2), $value['username']);

    	}
    	


    	header("Pragma: public");header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header('Content-Disposition:attachment;filename="采购-' . date('YmdHis') . '.xls"');
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
    }


    public function xiaosdaochu($data){
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '单据编号');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '单据日期');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '客户');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '单据摘要');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '仓库');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '物料组');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '物料名称');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '单位');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '换算率');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '数量');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '单价');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '金额');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '备注');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '备注');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '制单人');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '经手人');


        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['xiaos_xt_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['xiaos_date']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($key+2), $value['kehu_name'] . '-' . $value['kehu_dizhi']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($key+2), $value['xiaos_zhaiy']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($key+2), $value['cangk_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($key+2), $value['wuliao_zu']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($key+2), $value['wuliao_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($key+2), $value['danw_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($key+2), $value['danw_huans']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($key+2), $value['shul']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($key+2), $value['danj']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . ($key+2), $value['jine']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . ($key+2), $value['beizhu']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . ($key+2), $value['jiez_status']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . ($key+2), $value['username']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . ($key+2), $value['yuang']);

        }
        


        header("Pragma: public");header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="销售-' . date('YmdHis') . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }


    public function kehudaochu($data){
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '客户');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '地址');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '联系人');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '联系方式');

        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['kehu_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['kehu_dizhi']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($key+2), $value['kehu_lianxr']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($key+2), $value['kehu_lianxfs']);
        }
        


        header("Pragma: public");header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="客户-' . date('YmdHis') . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }


    public function shoukuandaochu($data){
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '日期');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '单据ID');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '客户');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '地址');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '摘要');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '收款类别');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '实收金额');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '折扣金额');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '制单人');



        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['fdate']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['shouk_xt_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($key+2), $value['kehu_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($key+2), $value['kehu_dizhi']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($key+2), $value['zhaiyao']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($key+2), $value['shoukleibie']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($key+2), $value['shishou']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($key+2), $value['zhekou']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($key+2), $value['username']);

        }
        


        header("Pragma: public");header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="收款-' . date('YmdHis') . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }


    public function fukuandandaochu($data){
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '日期');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '单据ID');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '供应商');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '地址');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '摘要');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '已付金额');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '折扣金额');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '制单人');



        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['fdate']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['fukuan_xt_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($key+2), $value['gongys_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($key+2), $value['gongys_dizhi']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($key+2), $value['zhaiyao']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($key+2), $value['shifu']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($key+2), $value['zhekou']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($key+2), $value['username']);

        }
        


        header("Pragma: public");header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="付款-' . date('YmdHis') . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }


    public function qitashouzhidaochu($data){
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '日期');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '单据ID');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '摘要');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '类别');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '金额');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '制单人');



        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['fdate']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['shouz_xt_id']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($key+2), $value['zhaiyao']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($key+2), $value['leibie']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($key+2), $value['jine']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($key+2), $value['username']);

        }
        


        header("Pragma: public");header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="收支-' . date('YmdHis') . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }


    public function kehuqiankdaochu($data){
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '客户');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '欠款');


        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['kehu_name'] . '-' . $value['kehu_dizhi']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['qiank']);

        }
        


        header("Pragma: public");header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="客户欠款-' . date('YmdHis') . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }


    public function gongysqiankdaochu($data){
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '供应商');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '欠款');


        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key+2), $value['gongys_name'] . '-' . $value['gongys_dizhi']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($key+2), $value['qiank']);

        }
        


        header("Pragma: public");header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="供应商欠款-' . date('YmdHis') . '.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

}
