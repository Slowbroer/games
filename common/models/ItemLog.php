<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "ItemLog".
 *
 * @property integer $seq
 * @property string $acc
 * @property string $name
 * @property string $itemcode
 * @property integer $sn
 * @property string $Iname
 * @property string $Ilvl
 * @property integer $Iskill
 * @property integer $Iluck
 * @property string $Iext
 * @property integer $Iset
 * @property integer $I380
 * @property integer $Ijh
 * @property string $sentdate
 */
class ItemLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ItemLog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['acc', 'name', 'itemcode', 'Iname', 'Ilvl', 'Iext'], 'string'],
            [['sn', 'Iskill', 'Iluck', 'Iset', 'I380', 'Ijh'], 'integer'],
            [['sentdate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'seq' => 'Seq',
            'acc' => 'Acc',
            'name' => 'Name',
            'itemcode' => 'Itemcode',
            'sn' => 'Sn',
            'Iname' => 'Iname',
            'Ilvl' => 'Ilvl',
            'Iskill' => 'Iskill',
            'Iluck' => 'Iluck',
            'Iext' => 'Iext',
            'Iset' => 'Iset',
            'I380' => 'I380',
            'Ijh' => 'Ijh',
            'sentdate' => 'Sentdate',
        ];
    }

    public function getLastsn()//
    {
        $item_log =  self::find()->select("min(sn) as last_sn")->asArray()->one();
        return $item_log['last_sn'];
    }

    public function add_log($code){

        $this->acc = $code['acc'];
        $this->name = $code['name'];
        $this->itemcode = $code['itemcode'];
        $this->sn = $code['sn'];
        $this->Iname = $code['Iname'];
        $this->sentdate = $code['sentdate'];
        return $this->save();

    }

    public function lists($filter = array())
    {
        $where = array();
        $query = $this->find()->where($where)->asArray();
        $count = $query->count();
        $page = new Pagination(['totalCount' => $count,'pageSize'=>30,]);

        $lists = $query->offset($page->offset)->limit($page->limit)->all();



        return array('lists'=>$lists,'page'=>$page);

    }
}
