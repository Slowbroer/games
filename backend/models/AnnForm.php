<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/2
 * Time: 23:44
 */

namespace backend\models;

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
                ['content', 'string', 'min' => 2, 'max' => 255],
            ];
    }

    public function update()
    {
        if (!$this->validate()) {
            return null;
        }

        if($this->id)
        {
            $ann = Announcement::findOne($this->id);
        }
        else
        {
            $ann = new Announcement();
            $ann->announcement_id = $this->id;
        }

        $ann->name = $this->title;
        $ann->announcement_content = $this->content;
        $ann->type = $this->type_id;


        return $ann->save()? $ann : null;
    }
}