<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prize".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $prize_value
 * @property string $prize_name
 * @property integer $add_time
 * @property integer $update_time
 * @property integer $proportion
 * @property integer $sort
 * @property integer $limit_number   0表示不限数量
 * @property integer $cost
 * @property integer $is_able
 */


class Prize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prize';//奖项表
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'proportion', 'sort'], 'required'],
            [['name','prize_name'], 'string'],
            [['type', 'prize_value', 'add_time', 'update_time', 'proportion', 'sort', 'limit_number', 'cost','is_able'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名字',
            'type' => '种类',//0表示没有奖励  ，1表示积分，2表示装备，3表示套装
            'prize_value' => '奖励的值',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
            'proportion' => '占比',//占比
            'sort' => '排序',
            'limit_number' => '限制数量',
            'cost' => '需要花费的积分',
        ];
    }


    public function get_as_arrays(){//get all the record
        return $this->find()->select('id,name,sort,proportion,limit_number')->where(['is_able'=>1])->orderBy('sort')->asArray()->all();
    }

    public function get_by_id($id){//find a record by id
        return $this->find()->where(['id'=>$id])->asArray()->one();
    }

    public function prize_info($id){
        return $this->find()->where(['id'=>$id])->one();
    }

}
