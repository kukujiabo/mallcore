<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use Core\Service\CurdSv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * 用户联合信息
 *
 * @author Meroc Chen <398515393@qq.com> 2017-12-09
 */
class MemberUnionInfoSv extends BaseService {

  use CurdSv;

  public function getList($data) {

    $query = array();

    if ($data['member_name']) {
    
      $query['member_name'] = $data['member_name'];
    
    }
    if ($data['user_tel']) {
    
      $query['user_tel'] = $data['user_tel'];
    
    }
    if ($data['card_id']) {
    
      $query['card_id'] = $data['card_id'];
    
    }
    if ($data['status']) {
    
      $query['status'] = $data['status'];
    
    }
    if ($data['remark']) {
    
      $query['remark'] = $data['remark'];
    
    }

    if ($data['reg_start_time']) {
    
      $startTime = date('Y-m-d H:i:s', $data['reg_start_time']);

      $query['reg_time'] = "eg|{$startTime}";
    
    }
    if ($data['reg_end_time']) {

      $endTime = date('Y-m-d H:i:s', $data['reg_end_time'] + 86400);
    
      $query['reg_time'] = strlen($query['reg_time']) ? "{$query['reg_time']};el|{$endTime}" : "el|{$endTime}";
    
    }
    if ($data['reference']) {
    
      $query['reference'] = $data['reference'];
    
    }

    $query['is_system'] = 0;

    $fields = $data['fields'] ? $data['fields'] : '*';

    $order = $data['order'] ? $data['order'] : 'uid desc';

    if (!$data['excel']) {

      return self::queryList($query, $fields, $order, $data['page'], $data['page_size']);

    } else {
    
      $members = self::all($query, 'reg_time desc);' 

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Type:application/vnd.ms-excel');

      header('Content-Disposition: attachment;filename="订单数据.xlsx"');
      header('Cache-Control: max-age=0');
        
      $spreadsheet = new Spreadsheet();

      $titles = array( '姓名', '手机号', '推荐人', '推荐人手机号', '下单数', '下单总金额');
    
      $sheet = $spreadsheet->getActiveSheet();

      $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

      foreach($titles as $key => $title) {

        $sheet->setCellValue("{$characters[$key]}1", $title);
      
      }

      $row = 2;

      foreach($members as $member) {

        $column = 0;
      
        $memberData = array(
        
          'member_name' => $member['member_name'],
          'user_tel' => $member['user_tel'],
          'recommend_user' => $member['recommend_user'],
          'recommend_phone' => $member['recommend_phone'],
          'num' => $member['num'],
          'sum_money' => $member['sum_money']
        
        );

        foreach($memberData as $md) {
        
          $cell = "{$characters[$column]}{$row}";

          $sheet->setCellValue($cell, $md);

          $column++;
        
        }

        $row++;

      }

      $writer = new Xlsx($spreadsheet);

      $writer->save("php://output");

      exit(0);

    }

  }

}
