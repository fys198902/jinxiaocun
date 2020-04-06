<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
include_once 'vendor/PHPExcel/Classes/PHPExcel.php';
include_once 'vendor/PHPExcel/Classes/PHPExcel/Writer/Excel5.php';


class Daoru extends Common{
	

    public function kehu_daoru($filename){
        $objPHPExcel = new \PHPExcel();
    	$PHPReader = new \PHPExcel_Reader_Excel5($objPHPExcel);

        $PHPExcel = $PHPReader->load($filename);
        $currentSheet = $PHPExcel->getSheet(0);
        $allColumn = $currentSheet->getHighestColumn();
        $allRow = $currentSheet->getHighestRow();

        $row = [];
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            $column=1;
            for($currentColumn='A'; $currentColumn<=$allColumn; $currentColumn++){
                $address = $currentColumn . $currentRow;
                $cell = $currentSheet->getCell($address)->getValue();
                $row[$currentRow][$column] = $cell;
                $column++;
            }
        }

        Db::startTrans();
        try {
            $kehu = model('kehu');
            for($i=2; $i<=$allRow; $i++){
                $fdata['id'] = 0;
                $fdata['kehu_name'] = $row[$i][1];
                $fdata['kehu_dizhi'] = $row[$i][2];
                $fdata['kehu_lianxr'] = ($row[$i][3] == '')?'-':$row[$i][3];
                $fdata['kehu_lianxfs'] = ($row[$i][4] == '')?'-':$row[$i][4];
                $fdata['user_id'] = session('userid');
                $fdata['zhangt_id'] = session('zhangtao_id');

                if($kehu->checkunique($row[$i][1]) > 0){
                    throw new \Exception('客户名：<' . $row[$i][1] .'>重复，请修改后，再次导入');
                }

                if(!$kehu->store($fdata)){
                    throw new \Exception('第' . $i .'行导入失败');
                }
            }
            Db::commit();
            return json('导入成功');
        } catch (\Exception $e) {
            Db::rollback();
            return json($e->getMessage());
        }
        
    }


    public function gongys_daoru($filename){
        $objPHPExcel = new \PHPExcel();
        $PHPReader = new \PHPExcel_Reader_Excel5($objPHPExcel);

        $PHPExcel = $PHPReader->load($filename);
        $currentSheet = $PHPExcel->getSheet(0);
        $allColumn = $currentSheet->getHighestColumn();
        $allRow = $currentSheet->getHighestRow();

        $row = [];
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            $column=1;
            for($currentColumn='A'; $currentColumn<=$allColumn; $currentColumn++){
                $address = $currentColumn . $currentRow;
                $cell = $currentSheet->getCell($address)->getValue();
                $row[$currentRow][$column] = $cell;
                $column++;
            }
        }

        Db::startTrans();
        try {
            $gongys = model('gongys');
            for($i=2; $i<=$allRow; $i++){
                $fdata['id'] = 0;
                $fdata['gongys_name'] = $row[$i][1];
                $fdata['gongys_dizhi'] = $row[$i][2];
                $fdata['gongys_lianxr'] = ($row[$i][3] == '')?'-':$row[$i][3];
                $fdata['gongys_lianxfs'] = ($row[$i][4] == '')?'-':$row[$i][4];
                $fdata['user_id'] = session('userid');
                $fdata['zhangt_id'] = session('zhangtao_id');

                if($gongys->checkunique($row[$i][1]) > 0){
                    throw new \Exception('供应商：<' . $row[$i][1] .'>重复，请修改后，再次导入');
                }

                if(!$gongys->store($fdata)){
                    throw new \Exception('第' . $i .'行导入失败');
                }
            }
            Db::commit();
            return json('导入成功');
        } catch (\Exception $e) {
            Db::rollback();
            return json($e->getMessage());
        }
        
    }

}
