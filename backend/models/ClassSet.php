<?php
//职业类

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ClassSet".
 *
 * @property integer $id
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


    public function get_list(){
        return $this->find()->select("class_id,class_name")->asArray()->all();
    }

    public $career = array(0=>'魔法师',1=>'魔导师',2=>'神导师',3=>'神导师',16=>'剑士',17=>'骑士',18=>'神骑士',19=>'神骑士',32=>'弓箭手',33=>'圣射手',34=>'神射手',35=>'神射手',48=>'魔剑士',49=>'剑圣',50=>'剑圣',51=>'剑圣',64=>'圣导师',65=>'祭师',66=>'祭师',67=>'祭师',80=>'召唤术师',81=>'召唤导师',82=>'召唤巫师',83=>'召唤巫师',96=>'角斗士',97=>'角斗师',98=>'角斗师',99=>'角斗师');




}
