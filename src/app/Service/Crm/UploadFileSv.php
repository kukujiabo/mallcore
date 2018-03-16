<?php
namespace App\Service\Crm; 

use App\Service\BaseService;
use App\Interfaces\Crm\IUploadFile;

use PHPExcel_IOFactory;
use PHPExcel;

/**
 *
 * 上传文件处理
 *
 * @author jiangzhangchan <jiangzhangchan@qq.com> 2017-10-09
 *
 */
class UploadFileSv extends BaseService implements IUploadFile {

    /**
     * 上传文件处理
     * @param string $path 上传文件保存路径
     * @param int $type 1-纵向数组 2-横向数组
     */
    public function fileDispose($path, $type = 1) {

        set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');

        $reader = PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档

        $PHPExcel = $reader->load($path); // 文档名称

        $sheet = $PHPExcel->getSheet(0); // 读取第一个工作表(编号从 0 开始)

        $highestRow = $sheet->getHighestRow(); // 取得总行数

        $highestColumn = $sheet->getHighestColumn(); // 取得总列数

        $arr = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L',13=>'M', 14=>'N',15=>'O',16=>'P',17=>'Q',18=>'R',19=>'S',20=>'T',21=>'U',22=>'V',23=>'W',24=>'X',25=>'Y',26=>'Z');

        $count = count($arr);

        $array = array();

        if ($type == 1) {

            // 一次读取一列
            for ($row = 1; $row <= $highestRow; $row++) {

                for ($column = 0; $arr[floor($column/$count)].$arr[$column%$count] != $highestColumn; $column++) {

                    if ($row > 1) {

                        $key = $sheet->getCellByColumnAndRow($column, 1)->getValue();

                        $value = $sheet->getCellByColumnAndRow($column, $row)->getValue();

                        if (!$value) {

                            $value = '';

                        }

                        $array[$key][] = $value;

                    }

                }

            }

        } else {

            for ($row = 0; $row < $highestRow; $row++) {

                $arrays = array();

                for ($column = 0; $arr[floor($column/$count)].$arr[$column%$count] != $highestColumn; $column++) {

                    $value = $sheet->getCellByColumnAndRow($column, $row + 1)->getValue();
                    
                    if (!$value) {

                        $value = '';

                    }

                    $arrays[] = $value;

                }

                $array[$row] = $arrays;

            }

        }
        
        $info['total'] = count($array);

        $info['list'] = $array;

        return $info;

    }

}
