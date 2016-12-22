<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/6
 * Time: 14:00
 */

namespace frontend\models;


use backend\models\PKstatus;
use common\models\Guild;
use common\models\MEMBINFO;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use frontend\models\AccountCharacter;
use backend\models\ClassSet;
use common\models\Character;//角色类
use Yii;


class RankForm extends Model {

    public $server;//服务区
    public $career;//职业
    public $condition;//条件
    public $number;//数量
    public $type="character";//类型


    public function rules()
    {
        return [
            [['number'],'required'],
            [['server','career','number','condition'],'integer'],
            [['type'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'server'=>'服务区',
            'career'=>'职业',
            'condition'=>'排行条件',
            'number'=>'数量',
            'type'=>'类型'

        ];
    }


    public function c_rank()//英雄排行
    {

        if (!$this->validate()) {
            return null;
        }

        $where = " where m.ServerCode = ".$this->server;
        if($this->career!==''&&intval($this->career)>=0)
        {
            $where .= " and c.Class = $this->career ";
        }
//        $where = array();
//        $where['Character.ZY'] = isset($this->career)? $this->career:'';//职业表
//        $where['MEMBINFO.ServerCode'] = isset($this->server)? $this->server:'';//服务区

        $limit = isset($this->number)? $this->number:30;//查询数量

        $order = isset($this->condition)? "c.".$this->condition:"c.cLevel";

//        $mem= new Character();

//        $characters = $mem->find()->select("Character.Name,Character.Name,Character.cLevel,Character.Class,Character.ZY,Character.PkLevel")->joinWith(MEMBINFO::className())
//            ->onCondition("MEMBINFO.memb___id=Character.AccountID")
//            ->where($where)->orderBy($order)->limit($limit)->asArray()->all();
        $connect = Yii::$app->db;
        $sql = "select top $limit c.Name,c.cLevel,c.Class,c.ZY,c.PkLevel from Character as c left join MEMB_INFO as m on c.AccountID = m.memb___id ".$where." order by $order desc";

//        var_dump($sql);
        $command = $connect->createCommand($sql);
        $characters = $command->queryAll();

        $list = array();
        $class = new ClassSet();//职业名称表
        $class_list = $class->get_list();
        $class_array = ArrayHelper::map($class_list,"class_id","class_name");

        $pk = new PKstatus();
        $pk_status = $pk->getList();
        $pk_array = ArrayHelper::map($pk_status,"key_value","pk_status");

        foreach($characters as $key=>$character)
        {
            $characters[$key]['ZY_name'] = $class_array[$character['Class']];
            $characters[$key]["PK_name"] = ($character['PkLevel'] > 3)?(($character['PkLevel'] > 5)?"魔头":"恶人"):'义士';
//            $characters[$key]["PK_name"] = $pk_array[$character['PkLevel']];
        }
        return $characters;
    }

    public function g_rank(){//战盟排行

        if(!$this->validate()){
            return null;
        }

        $where=array();
        $order='';
        if(!empty($this->server)){
            $where['gm.server']=$this->server;
        }

//        var_dump($this->condition);
        if(!empty($this->condition)){
            if($this->condition == 1)
            {
                $order = "G_Count desc";
            }
            elseif($this->condition == 2)
            {
                $order = "G_Score desc";
            }
        }

        $limit = empty($this->number)? 30:$this->number;
//        $where['']

//        $query = new Query();
//        //TODO : confirm the relationship with Guild and GuildMasterApply
//        return $query->select("g.G_Name,g.G_Master,g.G_Notice")->from("Guild g")
//            ->leftJoin("GuildMasterApply gm",'gm.character_name=g.G_master and gm.guild_name=g.G_Name')
//            ->where($where)->orderBy($order)->all();//这里默认已经是返回数组了，和ar类不同


        $list = Guild::find()->select("G_Name,G_Master,G_Notice")
            ->where($where)
            ->limit($limit)
            ->orderBy($order)
            ->asArray()->all();

        return $list;
    }




}