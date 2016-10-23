<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "MEMB_INFO".
 *
 * @property integer $memb_guid
 * @property string $memb___id
 * @property string $memb__pwd
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
 * @property integer $vip_free
 * @property integer $member
 * @property integer $ZY
 * @property integer $jf
 * @property integer $rcb
 * @property integer $vip
 * @property string $Expired
 * @property string $sms_t
 * @property string $last_ip
 * @property string $last_s
 * @property string $bloc_date
 * @property string $TOPACC
 * @property string $TOPJP
 * @property string $QXENDTIME
 * @property string $LINZBSJ
 * @property string $LGONGZHISJ
 * @property string $STOPINFO
 * @property string $STOPTIME
 * @property string $QX
 * @property integer $partation
 * @property integer $servercode
 * @property integer $usedtime
 * @property integer $YB
 * @property integer $QZ
 * @property integer $RMB
 * @property integer $TsLevel
 * @property integer $LjRMB
 */
class MEMBINFO extends \yii\db\ActiveRecord implements IdentityInterface
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MEMB_INFO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memb___id', 'memb__pwd', 'memb_name'], 'required'],
            [['memb___id', 'memb__pwd', 'memb_name', 'sno__numb', 'post_code', 'addr_info', 'addr_deta', 'tel__numb', 'phon_numb', 'mail_addr', 'fpas_ques', 'fpas_answ', 'job__code', 'mail_chek', 'bloc_code', 'ctl1_code', 'sms_t', 'last_ip', 'last_s', 'TOPACC', 'TOPJP', 'STOPINFO', 'QX'], 'string'],
            [['appl_days', 'modi_days', 'out__days', 'true_days', 'Expired', 'bloc_date', 'QXENDTIME', 'LINZBSJ', 'LGONGZHISJ', 'STOPTIME'], 'safe'],
            [['vip_free', 'member', 'ZY', 'jf', 'rcb', 'vip', 'partation', 'servercode', 'usedtime', 'YB', 'QZ', 'RMB', 'TsLevel', 'LjRMB'], 'integer'],
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
            'memb__pwd' => 'Memb  Pwd',
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
            'vip_free' => 'Vip Free',
            'member' => 'Member',
            'ZY' => 'Zy',
            'jf' => 'Jf',
            'rcb' => 'Rcb',
            'vip' => 'Vip',
            'Expired' => 'Expired',
            'sms_t' => 'Sms T',
            'last_ip' => 'Last Ip',
            'last_s' => 'Last S',
            'bloc_date' => 'Bloc Date',
            'TOPACC' => 'Topacc',
            'TOPJP' => 'Topjp',
            'QXENDTIME' => 'Qxendtime',
            'LINZBSJ' => 'Linzbsj',
            'LGONGZHISJ' => 'Lgongzhisj',
            'STOPINFO' => 'Stopinfo',
            'STOPTIME' => 'Stoptime',
            'QX' => 'Qx',
            'partation' => 'Partation',
            'servercode' => 'Servercode',
            'usedtime' => 'Usedtime',
            'YB' => 'Yb',
            'QZ' => 'Qz',
            'RMB' => 'Rmb',
            'TsLevel' => 'Ts Level',
            'LjRMB' => 'Lj Rmb',
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne(['memb___id' => $id]);
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
        return $this->auth_key;
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
