<?php
namespace frontend\models;

use common\models\MEMBINFO;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\MEMBINFO',
                'targetAttribute'=>'mail_addr',
                'message' => 'There is no user with such email.'
//                'targetClass' => '\common\models\User',
//                'filter' => ['status' => User::STATUS_ACTIVE],
//                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()//这里会先判断token的有效性
    {
        /* @var $user User */
//        $user = User::findOne([
//            'status' => User::STATUS_ACTIVE,
//            'email' => $this->email,
//        ]);
        $user = MEMBINFO::findOne(['mail_addr'=>$this->email]);


        if (!$user) {
            return false;
        }
        
        if (!MEMBINFO::isPasswordResetTokenValid($user->password_reset_token)) {//如果token已经过期了，就会进行更新
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }

}
