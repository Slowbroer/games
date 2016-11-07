<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/6
 * Time: 14:00
 */

namespace frontend\models;


use common\models\MEMBINFO;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RankForm extends Model {

    public $server;//服务区
    public $career;//职业
    public $condition;//条件
    public $number;//数量
    public $type="character";//类型


    public function rules()
    {
        return [
            [['server','number'],'required'],
            [['server','career','number',],'integer'],
            [['type'],'string'],
        ];
    }


    public function c_rank()//英雄排行
    {

        if (!$this->validate()) {
            return null;
        }

        $model = new

        $where = array();
        $where['Character.ZY'] = isset($this->career)? $this->career:'';//职业表
        $where['MEMBINFO.ServerCode'] = isset($this->server)? $this->server:'';//服务区

        $limit = isset($this->number)? $this->number:30;//服务区

        $order = isset($this->condition)? Character::className().$this->condition:"Character.cLevel";

        $mem= new Character();

        $characters = $mem->find()->select("Character.Name,Character.Name,Character.cLevel,Character.ZY,Character.PkLevel")->joinWith(MEMBINFO::className())
            ->onCondition("MEMBINFO.memb___id=Character.AccountID")
            ->where($where)->orderBy($order)->limit($limit)->asArray()->all();

        //TODO:这里需要处理职业

        $list = array();

        $class_list = [
            '0'=>'法师',
            '1'=>'魔导士',
            '32'=>'',
            '33'=>'',
            '16'=>'',
            '17'=>'',
            '48'=>'',
            '64'=>'',

        ];//TODO:这里的职业是不是有要后台进行相应的设置呢，还是说有一个表记录
        "0法 1魔导 32精 33圣 16战 17骑 48魔 64圣导";

        foreach($characters as $key=>$character)
        {
            $characters[$key]['class_name'] = $character[''];
        }

//        var_dump($users);

    }

}