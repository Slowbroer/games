<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/10
 * Time: 下午6:53
 */

namespace backend\models;


use common\models\AnnouncementType;
use yii\base\Model;

class AnntypeForm extends Model//公告类型表单类
{

    public $type_name;
    public $id;


    public function rules(){
        return [
            ['type_name',"require"],
            ['type_name',"string",'min' => 2, 'max' => 50],
            ['type_name','unique','targetClass'=>'common\models\AnnouncementType',]
        ];
    }

    public function update()//更新或添加一个公告类型
    {
        if(!$this->validate())
        {
            return false;
        }

        if(empty($this->id))
        {
            $type = new AnnouncementType();
            $type->add_time = time();
        }
        else
        {
            $type = AnnouncementType::findOne(['id'=>$this->id]);
            $type->update_time = time();
        }

        $type->name = $this->type_name;

        return $type->save()? $type : false;

    }

}