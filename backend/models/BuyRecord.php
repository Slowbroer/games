<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/18
 * Time: 下午4:43
 */

namespace backend\models;


use common\models\ItemLog;
use yii\base\Model;

class BuyRecord extends Model
{

    public $user_name;//用户名
    public $type;//购买类型
    public $min_money;
    public $max_money;
    public $start_time;
    public $end_time;


    public function rules()
    {
        return [
            [['user_name','type','min_money','max_money','start_time','end_time'],'safe'],
        ];
    }

    public function loadRecord($filter)
    {
        $where = array();
        if(!empty($this->user_name))
        {
            $where[] = ['like','acc','%'.$this->user_name.'%'];

        }
        $ItemLog = new ItemLog();
        $record = $ItemLog->find()->where($where)->all();
    }


}