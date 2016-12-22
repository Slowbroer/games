<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/10
 * Time: 下午3:17
 */

namespace backend\models;


use yii\base\Model;

class PkForm extends Model
{

    public $id;
    public $name;
    public $key;


    public function rules(){
        return [
            [['key','name'],'require'],
            [['id','key'],'integer'],
            ['name','string'],
            ['key','unique','targetClass'=>'\backend\models\PKstatus','targetAttribute'=>'key_value','message'=>'这个pk状态的键值已经存在']
        ];
    }

    public function update(){
        if(!$this->validators)
        {
            return false;
        }

        if(empty($this->id))
        {
            $pk = new PKstatus();
        }
        else
        {
            $pk = PKstatus::findOne(['id'=>$this->id]);
        }
        $pk->key_value = $this->key;
        $pk->pk_status = $this->name;
        $pk->last_time = time();

        return $pk->save()? $pk : false;

    }
}