<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_prize".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $prize_id
 * @property string $prize_name
 * @property integer $used
 * @property integer $order_id   //兑换的记录id
 * @property integer $add_time
 * @property integer $update_time
 * @property integer $is_able
 */
class UserPrize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_prize';//用户获奖记录表
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_name', 'prize_id', 'prize_name', 'add_time', 'update_time'], 'required'],
            [['user_id', 'prize_id', 'used', 'order_id', 'add_time', 'update_time','is_able'], 'integer'],
            [['user_name', 'prize_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'prize_id' => 'Prize ID',
            'prize_name' => 'Prize Name',
            'used' => 'Used',
            'order_id' => 'Order ID',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
        ];
    }


    public static function is_enough($limit_number = '0',$id)//is enough or not
    {
        $num = self::find()->where(['prize_id'=>$id,'is_able'=>1])->asArray()->count();
        $num = intval($num);

        if($limit_number == 0)//limitless
        {
            return false;
        }

        if($num<$limit_number)//not enough
        {
            return false;
        }
        else//enough
        {
            return true;
        }
    }


    //$result   一个Prize记录 的数组
    public function add_log($user_id,$result = array()){//添加一条记录

        if(is_array($result))
        {
            $this->user_id = $user_id;
            $this->user_name = $user_id;
            $this->add_time = time();
            $this->update_time = time();

            $this->prize_id = isset($result['id'])? $result['id']:0;
            $this->prize_name = isset($result['name'])? $result['name']:'未找到奖品';

            return $this->save() ? true:false;

        }
        return false;
    }
}
