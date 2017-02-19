<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/10
 * Time: 下午6:53
 */

namespace backend\models;


use common\models\Announcement;
use common\models\AnnouncementType;
use yii\base\Model;

class AnntypeForm extends Model//公告类型表单类
{

    public $type_name;
    public $id;


    public function rules(){
        return [

            ['type_name',"required"],
            ['type_name',"string",'min' => 2, 'max' => 50],
//            ['type_name','unique','targetClass'=>'common\models\AnnouncementType','targetAttribute'=>'name','message'=>'改类别已经存在！'],
            ['id','safe'],
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

        if($type->save()){
            Announcement::updateAll(['type_name'=>$this->type_name],['type'=>$this->id]);
            return true;
        }
        else
        {
            return false;
        }

    }

}