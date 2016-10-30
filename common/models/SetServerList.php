<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%SetServerList}}".
 *
 * @property integer $ID
 * @property string $ServerName
 * @property integer $Type
 * @property integer $Largest_ZS
 * @property integer $Smallest_ZS
 * @property integer $NewRoleToPoint
 * @property integer $OnlineMoney
 * @property integer $Partation
 */
class SetServerList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%SetServerList}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ServerName', 'Type', 'Largest_ZS', 'Smallest_ZS', 'NewRoleToPoint', 'OnlineMoney', 'Partation'], 'required'],
            [['ServerName'], 'string'],
            [['Type', 'Largest_ZS', 'Smallest_ZS', 'NewRoleToPoint', 'OnlineMoney', 'Partation'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ServerName' => 'Server Name',
            'Type' => 'Type',
            'Largest_ZS' => 'Largest  Zs',
            'Smallest_ZS' => 'Smallest  Zs',
            'NewRoleToPoint' => 'New Role To Point',
            'OnlineMoney' => 'Online Money',
            'Partation' => 'Partation',
        ];
    }


    public function get_list()
    {
//        return self::find()->select(['ID','ServerName'])->asArray()->all();//会报对象名没用

        return $this->find()->select(['ID','ServerName'])->asArray()->all();
    }


}
