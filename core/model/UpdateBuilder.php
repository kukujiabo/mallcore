<?php
namespace Core\Model;

/**
 * 更新构造器类
 *
 * @author Meroc Chen <398515393@qq.com> 2017-11-15
 */
trait UpdateBuilder {

    public static function buildUpdate($data, $operation) {

        $updateData = array(); 

        foreach($data as $key => $value) {

            /**
             * 累加操作
             */
            switch ($operation[$key]) {
          
                case 'accumulate':
          
                      $value = (String)$value;

                      if(strpos($value, '+') === 0) {

                        $value = substr($value, 1, strlen($value) - 1);

                        $updateData[$key] = new \NotORM_Literal("{$key} + {$value}");

                      } else {

                        $updateData[$key] = $value;

                      }

                    break;

                default:

                    $updateData[$key] = $value;

                    break;
            }

        }

        return $updateData;

    }

}
