<?php
//系统配置模块

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "systemconfig".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property integer $update_time
 * @property string $type
 * @property string $options
 */
class Systemconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'systemconfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['key', 'value', 'type', 'options'], 'string'],
            [['update_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'update_time' => 'Update Time',
            'type' => 'Type',
            'options' =>'options',
        ];
    }

    public function all()
    {
        Yii::$app->language = 'zh-CN';
        $lists = $this->find()->asArray()->all();
        foreach ($lists as $key=>$value)
        {
            $lists[$key]['name'] = Yii::t("Systemconfig",$value['key']);
        }
        return $lists;
    }

    public static function loadConfig()
    {

        $config = self::find()->asArray()->all();
        $array = ArrayHelper::map($config,'key','value');
        return $array;
    }
}
