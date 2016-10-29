<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%MEMB_INFO}}".
 *
 * @property integer $memb_guid
 * @property string $memb___id
 * @property string $memb_name
 * @property string $sno__numb
 * @property string $post_code
 * @property string $addr_info
 * @property string $addr_deta
 * @property string $tel__numb
 * @property string $phon_numb
 * @property string $mail_addr
 * @property string $fpas_ques
 * @property string $fpas_answ
 * @property string $job__code
 * @property string $appl_days
 * @property string $modi_days
 * @property string $out__days
 * @property string $true_days
 * @property string $mail_chek
 * @property string $bloc_code
 * @property string $ctl1_code
 * @property string $QX
 * @property integer $jf
 * @property integer $ServerCode
 * @property integer $UsedTime
 * @property integer $MemberType
 * @property integer $MemberResetChrNum
 * @property string $GetItemDay
 * @property string $memb__pwd
 * @property string $GetInfoDay
 * @property string $authkey
 *
 * @property MEMBDETA[] $mEMBDETAs
 */
class MEMBINFO extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%MEMB_INFO}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memb___id', 'memb_name', 'sno__numb', 'bloc_code', 'ctl1_code','memb__pwd'], 'required'],
            [['memb___id', 'memb_name', 'sno__numb', 'post_code', 'addr_info', 'addr_deta', 'tel__numb', 'phon_numb', 'mail_addr', 'fpas_ques', 'fpas_answ', 'job__code', 'mail_chek', 'bloc_code', 'ctl1_code', 'QX', 'memb__pwd','authkey'], 'string'],
            [['appl_days', 'modi_days', 'out__days', 'true_days', 'GetItemDay', 'GetInfoDay'], 'safe'],
            [['jf', 'ServerCode', 'UsedTime', 'MemberType', 'MemberResetChrNum'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'memb_guid' => 'Memb Guid',
            'memb___id' => 'Memb   ID',
            'memb_name' => 'Memb Name',
            'sno__numb' => 'Sno  Numb',
            'post_code' => 'Post Code',
            'addr_info' => 'Addr Info',
            'addr_deta' => 'Addr Deta',
            'tel__numb' => 'Tel  Numb',
            'phon_numb' => 'Phon Numb',
            'mail_addr' => 'Mail Addr',
            'fpas_ques' => 'Fpas Ques',
            'fpas_answ' => 'Fpas Answ',
            'job__code' => 'Job  Code',
            'appl_days' => 'Appl Days',
            'modi_days' => 'Modi Days',
            'out__days' => 'Out  Days',
            'true_days' => 'True Days',
            'mail_chek' => 'Mail Chek',
            'bloc_code' => 'Bloc Code',
            'ctl1_code' => 'Ctl1 Code',
            'QX' => 'Qx',
            'jf' => 'Jf',
            'ServerCode' => 'Server Code',
            'UsedTime' => 'Used Time',
            'MemberType' => 'Member Type',
            'MemberResetChrNum' => 'Member Reset Chr Num',
            'GetItemDay' => 'Get Item Day',
            'memb__pwd' => 'Memb  Pwd',
            'GetInfoDay' => 'Get Info Day',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMEMBDETAs()
    {
        return $this->hasMany(MEMBDETA::className(), ['memb_guid' => 'memb_guid']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['memb_guid' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->authkey;
    }

    public function generateAuthKey()
    {
        $this->authkey = Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function setPassword($password)
    {
        $this->memb__pwd = md5($password);
    }

    public function validatePassword($password)
    {
        if(trim(md5($password))==trim($this->memb__pwd))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function findByUsername($user_name)
    {
        return static::findOne(['memb___id' => $user_name]);
    }
}
