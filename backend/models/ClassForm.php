<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/10
 * Time: 下午2:18
 */

namespace backend\models;


use yii\base\Model;
use backend\models\ClassSet;

class ClassForm extends Model
{

    public $id;
    public $name;
    public $key;


    public function rules()
    {
        return [
            [['key','name'],'required'],
            [['id','key'],'integer'],
            ['name','string'],
            ['key','unique','targetClass'=>'\backend\models\ClassSet','targetAttribute'=>'class_id','message'=>'这个角色的键值已经存在！']
        ];
    }

    public function update()
    {
        if(!$this->validators)
        {
            return false;
        }
        if(empty($this->id))
        {
            $class = new ClassSet();
        }
        else
        {
            $class = ClassSet::findOne(['id'=>$this->id]);
        }
        $class->class_id = $this->key;
        $class->class_name = $this->name;
        $class->last_time = time();


        return $class->save()? $class:false;
    }

}