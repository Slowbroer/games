<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "announcement_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $add_time
 * @property string $update_time
 */
class AnnouncementType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announcement_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['add_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
        ];
    }


    public function getLIst()//返回列表
    {
        return self::find()->select(['id','name'])->asArray()->all();
    }
}
