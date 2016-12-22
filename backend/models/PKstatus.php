<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "PKstatus".
 *
 * @property integer $id
 * @property string $pk_status
 * @property integer $key_value
 * @property integer $last_time
 */
class PKstatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PKstatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pk_status', 'key_value'], 'required'],
            [['id', 'key_value', 'last_time'], 'integer'],
            [['pk_status'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pk_status' => 'Pk Status',
            'key_value' => 'Key Value',
            'last_time' => 'Last Time',
        ];
    }


    public function getList(){
        return $this->find()->select("pk_status,key_value")->asArray()->all();
    }
}
