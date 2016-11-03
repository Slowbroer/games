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

    public function rules()
    {
        return [
            [['username','password','capture'],'string'],
            [['username','password','server'],'required'],
            ['server','integer']
        ];
    }

    public function login(){


    }


}