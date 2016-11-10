<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/6
 * Time: 14:00
 */

namespace frontend\models;


use backend\models\PKstatus;
use common\models\MEMBINFO;
use yii\base\Model;
use yii\db\Query;
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

        $where = array();
        $where['Character.ZY'] = isset($this->career)? $this->career:'';//职业表
        $where['MEMBINFO.ServerCode'] = isset($this->server)? $this->server:'';//服务区

        $limit = isset($this->number)? $this->number:30;//服务区

        $order = isset($this->condition)? Character::className().$this->condition:"Character.cLevel";

        $mem= new Character();

        $characters = $mem->find()->select("Character.Name,Character.Name,Character.cLevel,Character.Class,Character.ZY,Character.PkLevel")->joinWith(MEMBINFO::className())
            ->onCondition("MEMBINFO.memb___id=Character.AccountID")
            ->where($where)->orderBy($order)->limit($limit)->asArray()->all();


        $list = array();
        $class = new ClassSet();//职业名称表
        $class_list = $class->getList();
        $class_array = ArrayHelper::map($class_list,"class_id","class_name");

        $pk = new PKstatus();
        $pk_status = $pk->getList();
        $pk_array = ArrayHelper::map($pk_status,"key_value","pk_status");



        foreach($characters as $key=>$character)
        {
            $characters[$key]['ZY_name'] = $class_array[$characters['Class']];
            $characters[$key]["PK_name"] = $pk_array[$characters['PkLevel']];
        }

        return $characters;

//        var_dump($users);

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

        if(!empty($this->condition)){
            $order=$this->condition;
        }

        $limit = empty($this->number)? 30:$this->number;
//        $where['']

        $query = new Query();
        //TODO : confirm the relationship with Guild and GuildMasterApply
        return $query->select("g.G_Name,g.G_Master,g.G_Notice")->from("Guild g")
            ->leftJoin("GuildMasterApply gm",'gm.character_name=g.G_master and gm.guild_name=g.G_Name')
            ->where($where)->orderBy($order)->all();//这里默认已经是返回数组了，和ar类不同

//            $query->select(['user.name AS author', 'post.title as title'])
//                ->from('user')
//                ->leftJoin('post', 'post.user_id = user.id');
//        $query->leftJoin(['u' => $subQuery], 'u.id=author_id');
    }




}