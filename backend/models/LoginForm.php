<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/3
 * Time: 23:08
 */

namespace backend\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model{

    public $username;
    public $password;
    public $capture;
    public $server;
    public $rememberMe;
    public $_user;

    public function rules()
    {
        return [
            [['username','password','capture'],'string'],
            [['username','password'],'required'],
            ['server','integer'],
            ['rememberMe','safe'],
            ['password', 'validatePassword'],
        ];
    }

    public function login(){//登录功能

        if($this->validate()){
//            var_dump($this->getUser());
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else
        {
            return false;
        }

    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    protected function getUser(){
//        return SystemAdmin::findByUsername($this->username);

        if ($this->_user === null) {
            $this->_user = SystemAdmin::findByUsername($this->username,$this->server);
        }

        return $this->_user;
    }


}