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


    public function rules(){
        return [
            [['id','name'],'require'],
            ['id','integer'],
            ['name','string'],
        ];
    }

    public function update(){
        if(!$this->validators)
        {
            return false;
        }

        $pk = new PKstatus();
        $pk->key_value = $this->id;
        $pk->pk_status = $this->name;
        $pk->last_time = time();

        return $pk->save()? $pk : false;

    }
}