<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/17
 * Time: 上午10:30
 */

namespace backend\models;


use yii\base\Model;

class ConfigureForm extends Model
{
    public $prize_cost;//抽奖需要花费的金额
    public $prize_cost_type;//抽奖花费类型，0；金额   1:积分

    public $point_field = 'jf';//积分字段

    public $point_to_money = 100;//积分换算为金额

    public $web_name = "my webshop";


    public function rules()
    {
        return [
            [['prize_cost','prize_cost_type','point_to_money','point_field','web_name'],'required'],
            [['prize_cost','prize_cost_type','point_to_money',],'integer'],
            [['point_field','web_name'],'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'prize_cost'=>'抽奖花费',
            'prize_cost_type'=>'抽奖花费类型',
            'point_to_money'=>'积分金额兑换',
            'point_field'=>'积分字段',
            'web_name'=>'网站名',
        ];
    }


}