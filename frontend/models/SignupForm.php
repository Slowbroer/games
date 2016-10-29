<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\MEMBINFO;
use yii\validators\Validator;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $nickname;
    public $confirm_password;
    public $question_id;
    public $answer;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\MEMBINFO', 'targetAttribute'=>'memb___id', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['nickname', 'trim'],
            ['nickname', 'required'],
            ['nickname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\MEMBINFO','targetAttribute'=>'mail_addr', 'message' => 'This email address has already been taken.'],

            [['password','confirm_password'], 'required'],
            [['password','confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'operator' => '===']



        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
//        var_dump(Validator::$builtInValidators);
        if (!$this->validate()) {
            return null;
        }

//        die($this->username);
        $user = new MEMBINFO();
        $user->memb___id = $this->username;//$this->username是指在signupform的數據，而$user->username則是表示user表中的一個字段
        $user->mail_addr = $this->email;
        $user->setPassword($this->password);
        $user->memb_name = $this->nickname;
        $user->sno__numb = "1111111111111";
        $user->bloc_code = '0';
        $user->ctl1_code = '0';
//        $user->generateAuthKey();
//        var_dump(json_encode($user));
        
        return $user->save() ? $user : null;
    }
}
