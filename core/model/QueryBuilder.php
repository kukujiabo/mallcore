<?php
namespace Core\Model;

/**
 * 查询条件拼接类
 *
 * @author Meroc Chen <398515393@qq.com> 2017-10-17
 */
class QueryBuilder {

  /**
   * 组装查询条件
   *
   * @param array $condition
   * @param array $operation
   *
   * @return array $where
   */
  public static function makeQuery($condition, $operation) {

    $where = array(); 

    foreach($condition as $key => $value) {

      $value = iconv("UTF-8", "GB2312//IGNORE", $value);

      /**
       * 区间操作
       */
      switch ($operation[$key]) {
      
        /**
         * between操作
         * 
         * eg. '[e]g|min;[e]l|max'
         */

        case 'range':

          if (strpos($value, ';') > 0) {
          
            $operations = explode(';', $value);

            $greater = explode('|', $operations[0]);

            $smaller = explode('|', $operations[1]);

            $op1 = $greater[0] == 'g' ? '>' : '>=';

            $where[" {$key} {$op1} ? "] = $greater[1];

            $op2 = $smaller[0] == 'l' ? '<' : '<=';

            $where[" {$key} {$op2} ? "] = $smaller[1];
          
          } else {

            if (strpos($value, '|') > 0) {

              $operations = explode('|', $value);

              /**
               * 大于操作
               *
               * eg. '[e]g|min', '[e]l|max'
               */
              if (strpos($operations[0], 'g') >= 0) {

                $op = $operations[0] == 'eg' ? '>=' : '>';
              
                $where[" {$key} {$op} ? "] = $operations[1];
              
              } elseif (strpos($operations[0], 'l') >= 0) {
              
                $op = $operations[0] == 'el' ? '<=' : '<';
              
                $where[" {$key} {$op} ? "] = $operations[1];
              
              }

            } else {

              $where["{$key}"] = $value;

            }
          
          }

          break;

        case 'like':

          /**
           * 模糊匹配
           */
          $where[" {$key} LIKE ? "] = "%{$value}%";

          break;
      
        case 'in':
          /**
           * 枚举操作
           */
          $where["{$key}"] = explode(',', $value);

          break;
      

        case 'not_in':
          /**
           * 排除操作
           */
          $where["NOT {$key}"] = explode(',', $value);

          break;
        
        default:

          $where["{$key}"] = $value;

      }
    
    }

    return $where;

  }

}
