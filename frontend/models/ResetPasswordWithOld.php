<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/5
 * Time: 下午7:37
 */

namespace frontend\models;


use common\models\MEMBINFO;
use yii\base\Model;
use yii\base\InvalidParamException;

class ResetPasswordWithOld extends Model
{
    public $memb_id;
    public $old_password;
    public $new_password;
    public $confirm_password;
    private $_user;

    public function rules()
    {
        return [
            [['old_password','new_password','confirm_password',],'string','length' => [6, 20]],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'operator' => '==='],
            [['memb_id'],'string'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'old_password'=>'旧密码',
            'new_password'=>'新密码',
            'confirm_password'=>'确认密码',
            'memb_id'=>'memb_id',
        ];
    }
    public function validate($attributeNames = null, $clearErrors = true)
    {
        $this->_user = MEMBINFO::findOne([
            'memb___id'=>$this->memb_id,
            'memb__pwd'=>$this->old_password,
        ]);
        if(!$this->_user)
        {
            throw new InvalidParamException('Wrong password reset token.');
        }
        return parent::validate($attributeNames,$clearErrors);

    }
    public function reset_password()
    {
        $this->_user->setPassword($this->new_password);
        return $this->_user->save()? true:false;

    }
}