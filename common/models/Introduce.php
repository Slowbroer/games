<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "introduce".
 *
 * @property integer $id
 * @property string $content
 * @property string $title
 * @property integer $is_able
 * @property integer $is_show
 * @property string $brief
 * @property integer $add_time
 * @property integer $update_time
 */
class Introduce extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'introduce';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'title',  'add_time'], 'required'],
            [['content', 'title', 'brief'], 'string'],
            [['is_able', 'is_show', 'add_time','update_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'title' => '标题',
            'is_able' => 'Is Able',
            'is_show' => '是否显示',
            'brief' => 'Brief',
            'add_time' => 'Add Time',
            'update_time' => "更新时间",
        ];
    }

    public function all($filter=array())
    {
//        $cache = Yii::$app->cache1;


        $where['is_able']=1;
//        $where['is_show']=1;
        $query = $this->find()->select("id,content,title,brief,update_time")->where($where)->asArray();
        $count = $query->count();

        $page_size = isset($filter['page_size'])? $filter['page_size']:20;
//        var_dump($query);
        $page = new Pagination(['pageSize'=>$page_size,'totalCount'=>$count]);


        $result['list'] = $query->offset($page->offset)->limit($page->limit)->orderBy("add_time desc")->all();
        $result['page'] = $page;
        return $result;
    }

    public function recent($number=10)
    {
        $where['is_able']=1;
        $where['is_show']=1;
        $lists = $this->find()->select("id,content,title,brief")->where($where)->limit($number)->orderBy("add_time")->asArray()->all();
//        var_dump($lists);
        return $lists;
    }

    public function info($id)
    {
        $info = $this->find()->where(['id'=>$id])->asArray()->one();
        return $info;
    }






}
