<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/10
 * Time: 下午2:18
 */

namespace backend\models;


use yii\base\Model;

class ClassForm extends Model
{

    public $id;
    public $name;


    public function rules()
    {
        return [
            [['id','name'],'required'],
            ['id','integer'],
            ['name','string']
        ];
    }

    public function update()
    {
        if(!$this->validators)
        {
            return false;
        }
        $class = new ClassSet();
        $class->class_id = $this->id;
        $class->class_name = $this->name;
        $class->last_time = time();


        return $class->save()? $class:false;
    }

}