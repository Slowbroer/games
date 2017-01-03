<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ann_comment".
 *
 * @property integer $id
 * @property string $content
 * @property integer $ann_id
 * @property integer $user_id
 * @property string $user_name
 * @property integer $add_time
 * @property integer $parent_id
 * @property string $blog_title
 * @property string $brief
 * @property integer $update_tiem
 */
class AnnComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ann_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'ann_id', 'user_id', 'user_name', 'add_time', 'blog_title', 'brief', 'update_tiem'], 'required'],
            [['content', 'user_name', 'blog_title', 'brief'], 'string'],
            [['ann_id', 'user_id', 'add_time', 'parent_id', 'update_tiem'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '评价内容',
            'ann_id' => 'Ann ID',
            'user_id' => '用户id',
            'user_name' => '用户名',
            'add_time' => 'Add Time',
            'parent_id' => 'Parent ID',
            'blog_title' => 'Blog Title',
            'brief' => 'Brief',
            'update_tiem' => 'Update Tiem',
        ];
    }


    public function comment_list($announcement_id=0)
    {
        $id = empty($announcement_id)? $this->ann_id:$announcement_id;
        $lists = $this->find()->where(['ann_id'=>$id,'parent_id'=>0])->orderBy("add_time")->asArray()->all();
        foreach ($lists as $key=>$list)
        {
            $lists[$key]['time'] = date("Y-m-d H:i:s",$list);
        }

        return $lists;
    }

}
