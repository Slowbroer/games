<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "MEMB_STAT".
 *
 * @property string $memb___id
 * @property integer $ConnectStat
 * @property string $ServerName
 * @property string $IP
 * @property string $ConnectTM
 * @property string $DisConnectTM
 */
class MEMBSTAT extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MEMB_STAT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memb___id'], 'required'],
            [['memb___id', 'ServerName', 'IP'], 'string'],
            [['ConnectStat'], 'integer'],
            [['ConnectTM', 'DisConnectTM'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'memb___id' => 'Memb   ID',
            'ConnectStat' => 'Connect Stat',
            'ServerName' => 'Server Name',
            'IP' => 'Ip',
            'ConnectTM' => 'Connect Tm',
            'DisConnectTM' => 'Dis Connect Tm',
        ];
    }

    public static function connect_stat($id)
    {
        $online =  self::findOne(['memb___id'=>$id]);
        if($online)
        {
            return $online->ConnectStat==1? true:false;
        }
        else
        {
            return true;
        }

    }
}
