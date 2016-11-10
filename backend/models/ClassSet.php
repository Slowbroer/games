<?php
//职业类

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ClassSet".
 *
 * @property integer $class_id
 * @property string $class_name
 * @property integer $last_time
 */
class ClassSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ClassSet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id', 'class_name'], 'required'],
            [['class_id', 'last_time'], 'integer'],
            [['class_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'class_id' => 'Class ID',
            'class_name' => 'Class Name',
            'last_time' => 'Last Time',
        ];
    }


    public function getList(){
        return $this->find()->select("class_id,class_name")->asArray()->all();
    }
}
