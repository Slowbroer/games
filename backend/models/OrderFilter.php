<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/7
 * Time: 下午8:28
 */

namespace backend\models;


use common\models\ItemLog;
use yii\base\Model;
use yii\data\Pagination;

class OrderFilter extends Model//订单管理的筛选表的类
{
    public $user_name;
    public $min_money;
    public $max_money;
    public $start_time;
    public $end_time;


    public function rules()
    {
        return [
            [['user_name'],'string'],
            [['min_money','max_money',],'integer'],
            [['start_time','end_time'],'string'],
        ];
    }

    public function queryOrders()
    {
//        $where = "where 1 ";
        $where1 = array();
        $where2 = array();
        $where3 = array();
        if($this->validate())
        {

            if(!empty($this->user_name))
            {
                $where1 = ['like','name',$this->user_name];
            }
//            if(!empty($this->start_time))
//            {
//                $where2 = ['>','convert(timestamp,convert(datetime,sentdate))','convert(timestamp,convert(datetime,'.$this->start_time.'))'];
//            }
//            if(!empty($this->end_time))
//            {
//                $where3 = ['<','convert(timestamp,convert(datetime,sentdate))','convert(timestamp,convert(datetime,'.$this->end_time.'))'];
//            }
            $ItemLog = new ItemLog();
            $query = $ItemLog->find()->where($where1)->andWhere($where2)->andWhere($where3)->asArray();
            $count = $query->count();
            $page = new Pagination(['totalCount' => $count,'pageSize'=>30,]);

            $order_lists['lists'] = $query->offset($page->offset)->limit($page->limit)->all();
            $order_lists['page'] = $page;


           return $order_lists;
        }
        else
        {
            return false;
        }

    }
}