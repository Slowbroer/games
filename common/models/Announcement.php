<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "announcement".
 *
 * @property integer $announcement_id
 * @property integer $type
 * @property string $name
 * @property string $announcement_content
 * @property string $add_time
 * @property string $update_time
 * @property string $type_name
 * @property integer $admin_id
 *
 * @property integer $enable
 */
class Announcement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'announcement_content', 'add_time', 'admin_id'], 'required'],
            [['type', 'admin_id','add_time', 'update_time','enable'], 'integer'],
            [['type_name', 'announcement_content'], 'string'],
            [['name',], 'string', 'length' => [3, 20]],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'announcement_id' => 'Announcement ID',
            'type' => 'Type',
            'name' => 'Name',
            'announcement_content' => 'Announcement Content',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
            'type_name' => 'Type Name',
            'admin_id' => 'Admin ID',

        ];
    }

    public function getList($filter=null)//返回列表
    {
        $where = array();
        if(!empty($filter['type']))
        {
            $where['type'] = $filter['type'];
        }
        return $this->find()->select(['announcement_id','type','name','add_time','type_name'])->where($where)->asArray()->all();
    }

    public function info($id)//返回详情
    {
        return $this->find()->where(['announcement_id'=>$id])->one();
    }

    public function del($id)
    {
        if(empty($id))
        {
            return false;
        }
        else
        {
            $this->enable = 0;
            $this->update_time = time();
            return ($this->save())? true:false;
        }
    }
}
