<?php

namespace App\Service\Crm;

use App\Service\BaseService;
use App\Interfaces\Crm\IMemberAccountRecord;
use App\Model\MemberAccountRecord;
use Core\Service\CurdSv;
use App\Service\Crm\UserSv;
use App\Service\Crm\MemberAccountSv;
use App\Service\Poss\PosSv;

/**
 * 会员账户记录
 *
 * @author: jiangzhangchan <jiangzhangchan@qq.com> 2017-11-02
 */
class MemberAccountRecordSv extends BaseService implements IMemberAccountRecord {

    use CurdSv;

    /**
     * 添加记录
     */
    public function addAccountRecords($data) {

        $data['create_time'] = date("Y-m-d H:i:s");

        try{

            return self::add($data);

        } catch (\Exception $e){

            throw new InternalServerErrorException('新增失败', 1);

        }

    }

    /**
     * 获取列表
     */
    public function getPossList($condition){

        if ($condition['account_type'] == 3) {

            return self::getList($condition);

        }

        $info_user = UserSv::getUserByToken($condition['token']);

        $condition['uid'] = $info_user['uid'];

        $where_member_account['uid'] = $condition['uid'];

        $info_member_account = MemberAccountSv::findOne($where_member_account);

        if ($condition['account_type'] == 1) {

            // 积分记录
            $list = PosSv::getMemberPointHistory(array('sCardID'=>$info_member_account['card_id']));

            $info = \App\pageDispose($list, $condition['page'], $condition['page_size']);

            $list = array();

            foreach ($info['list'] as $k => $v) {

              $array = array();

              $array['type_name'] = $v['积分类别'];

              $array['create_time'] = $v['销售日期'];

              $array['data_id'] = $v['销售单号'];

              $array['shop_name'] = $v['销售店铺'];

              if ($v['增加积分'] > 0) {

                $array['sign'] = 1;

                $number = $v['增加积分'];

              } elseif ($v['减少积分'] > 0) {

                $array['sign'] = -1;

                $number = $v['减少积分'];

              }

              $array['number'] = $number;


              $array['text'] = $v['备注'];

              $list[] = $array;

            }

            $info['list'] = $list;

        } elseif ($condition['account_type'] == 2) {

            // 余额记录
            $list = PosSv::getMemberBalanceHistory(array('sCardID'=>$info_member_account['card_id']));

            $info = \App\pageDispose($list, $condition['page'], $condition['page_size']);

            $list = array();

            foreach ($info['list'] as $k => $v) {

              $array = array();

              $array['id'] = $v['DocEntry'];

              $array['type_name'] = $v['DocType'];

              $array['create_time'] = $v['DocDate'];

              $array['data_id'] = $v['DocNum'];

              $array['shop_name'] = $v['ShpName'];

              if ($v['BalanceAdd'] > 0) {

                $array['sign'] = 1;

                $number = $v['BalanceAdd'];

              } elseif ($v['BalanceReduce'] > 0) {

                $array['sign'] = -1;

                $number = $v['BalanceReduce'];

              }

              $array['number'] = $number;

              $array['reward'] = $v['BalanceGift'];

              $array['text'] = $v['Memo'];

              $list[] = $array;

            }

            $info['list'] = $list;

        }

        return $info;

    }

    /**
     * 获取列表
     */
    public function getList($condition){

        if ($condition['way'] == 1 && $condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['uid'] = $info_user['uid'];

        }

        unset($condition['way']);

        unset($condition['token']);

        return self::queryList($condition, $condition['fields'], $condition['order'], $condition['page'], $condition['page_size']);

    }

    /**
     * 获取总数
     */
    public function getCount($condition){

        return self::queryCount($condition);

    }

    /**
     * 获取详情
     */
    public function getDetail($condition){

        if ($condition['way'] == 1 && $condition['token']) {

            $info_user = UserSv::getUserByToken($condition['token']);

            $condition['uid'] = $info_user['uid'];

        }

        unset($condition['way']);

        unset($condition['token']);

        $list = MemberAccountRecord::queryList($condition, $condition['fields'], $condition['order'], 0, 1);

        return $list[0];

    }

    /**
     * 编辑
     */
    public function edit($data) {

        if ($data['id']) {

            $condition['id'] = $data['id'];

        }

        unset($data['id']);

        return self::batchUpdate($condition, $data);

    }

}
