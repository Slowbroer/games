<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "SystemAdmin".
 *
 * @property integer $admin_id
 * @property string $admin_name
 * @property integer $admin_level
 * @property string $admin_power
 * @property string $mobile_phone
 * @property string $email
 * @property string $salt
 * @property string $authkey
 */
class SystemAdmin extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SystemAdmin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_name', 'admin_power', 'mobile_phone', 'email','salt','authkey'], 'string'],
            [['admin_level'], 'integer'],
            [['admin_name', 'mobile_phone', 'email','salt','admin_level'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'admin_name' => 'Admin Name',
            'admin_level' => 'Admin Level',
            'admin_power' => 'Admin Power',
            'mobile_phone' => 'Mobile Phone',
            'email' => 'Email',
            'salt' => 'salt',
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne(['admin_id'=>$id]);
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
        return static::findOne(['admin_name' => $user_name]);
    }
}
