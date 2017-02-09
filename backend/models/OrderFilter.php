<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/7
 * Time: 下午8:28
 */

namespace backend\models;


use yii\base\Model;

class OrderFilter extends Model
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
        $where = "where 1 ";
        if($this->validate())
        {
           if(!empty($this->user_name))
           {
               $where .= " and memb";//这里进行数据筛选，筛选出订单
           }
           $order_lists =array();

           return $order_lists;
        }
        else
        {
            return false;
        }

    }
}