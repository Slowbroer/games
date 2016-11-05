<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/2
 * Time: 23:44
 */

namespace backend\models;

use common\models\AnnouncementType;
use Yii;
use common\models\Announcement;
use yii\base\Model;

class AnnForm extends Model{

    public $content;
    public $title;
    public $type_id;
    public $id;


    public function rules()
    {
        return
            [
                [['type_id','content','title'],'required'],
                [['type_id'],'integer'],
                [['title'],'string'],
                ['content', 'string'],
            ];
    }

    public function update()
    {
        if (!$this->validate()) {
            return null;
        }

        if(!empty($this->id))
        {
            $ann = Announcement::findOne($this->id);
        }
        else
        {
            $ann = new Announcement();
            $ann->add_time = time();
//            $ann->announcement_id = $this->id;
        }

        if($ann)
        {
            $ann->type_name = AnnouncementType::findOne($this->type_id)->name;

            $ann->name = $this->title;
            $ann->announcement_content = $this->content;
            $ann->type = $this->type_id;
            $ann->admin_id = Yii::$app->user->id;//需要添加管理员id
            $ann->update_time = time();
        }



        return $ann->save()? $ann : null;
    }
}