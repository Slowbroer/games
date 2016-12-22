<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "MuItem".
 *
 * @property integer $Id
 * @property integer $ZbIndex
 * @property string $Name
 * @property integer $Prise
 * @property integer $PVP
 * @property integer $XQ
 * @property string $Hand
 * @property integer $Type
 * @property string $Wide
 * @property string $High
 * @property string $F
 * @property string $Z
 * @property string $G
 * @property string $M
 * @property string $S
 * @property string $H
 * @property string $naijiu
 * @property string $excellent
 * @property string $taozhuang
 * @property string $cate
 * @property string $qianghua
 * @property string $level
 * @property string $skill
 * @property string $luck
 * @property string $add
 */
class MuItem extends \yii\db\ActiveRecord
{
    public $item_type = array(
        '0'=>'剑',
        '1'=>'斧头',
        '2'=>'槌',
        '3'=>'矛',
        '4'=>'弓弩',
        '5'=>'手杖',
        '11'=>'头盔',
        '7'=>'铠甲',
        '8'=>'手套',
        '9'=>'裤子',
        '10'=>'靴子',
        '6'=>'盾牌',
        '12'=>'吊环，饰品',
        '13'=>'珠宝',
        '14'=>'翅膀',
        '15'=>'卷轴，魔法球，消费品',
    );

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'MuItem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ZbIndex', 'Prise', 'PVP', 'XQ', 'Type','naijiu','cate','excellent','taozhuang','qianghua','level','skill','luck','add'], 'integer'],
            [['Name', 'Hand', 'Wide', 'High', 'F', 'Z', 'G', 'M', 'S', 'H'], 'string'],
            [['ZbIndex', 'Prise', 'PVP', 'XQ', 'Type','naijiu','cate','excellent','taozhuang','qianghua','level','skill','luck','add'],
                'compare','compareValue' => 0, 'operator' => '>='],
            [['add'],'integer','max'=>3],
            [['level','PVP','cate'],'integer','max'=>15],
            [['ZbIndex','naijiu','excellent','taozhuang','qianghua'],'integer','max'=>255],
            [['skill','luck'],'integer','max'=>1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'ZbIndex' => 'Zb Index',
            'Name' => '名字',
            'Prise' => '价格',
            'PVP' => 'Pvp',
            'XQ' => 'Xq',
            'Hand' => 'Hand',
            'Type' => 'Type',
            'Wide' => 'Wide',
            'High' => 'High',
            'F' => 'F',
            'Z' => 'Z',
            'G' => 'G',
            'M' => 'M',
            'S' => 'S',
            'H' => 'H',
            'naijiu'=>'耐久',
            'excellent'=>'卓越',
            'cate'=>'',
            'taozhuang'=>'套装',
            'qianghua'=>'强化',
            'level'=>'增加等级',
            'skill'=>'技能',
            'luck'=>'幸运',
            'add'=>'追加',
        ];
    }
    public function getList($filter = array('count'=>30)){//
        $where = array();
        if(!empty($filter['pvp']))
        {
            $where['PVP'] = $filter['pvp'];
        }
        if($filter['type']!==null)
        {
            $where['Type'] = $filter['type'];
        }
        $pagination = new Pagination(['totalCount' => $filter['count'],'pageSize'=>1]);

        $result['lists'] = self::find()->where($where)->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        $result['page'] = $pagination;
        return $result;
    }



    public function getCode($ItemNums,$Code1,$Code2,$pvp)
    {
        if(!$this->validate())
        {
            return "";
        }

        $ItemCode = str_pad(base_convert($this->ZbIndex,10,16),2,0,STR_PAD_LEFT);

        $skill = base_convert($this->skill,10,2);
        $level = str_pad(base_convert($this->level,10,2),4,0,STR_PAD_LEFT);//TODO
        $luck = base_convert($this->luck,10,2);
        $add = str_pad(base_convert($this->add,10,2),2,0,STR_PAD_LEFT);//TODO

        $Code1 = base_convert($skill.$level.$luck.$add,2,16);//shuxing

        $naijiu = str_pad(base_convert($this->naijiu,10,16),2,0,STR_PAD_LEFT);

        $ItemNums = str_pad(base_convert($ItemNums,10,16),8,0,STR_PAD_LEFT);

        $excellent = str_pad(base_convert($this->excellent,10,16),2,0,STR_PAD_LEFT);

        $taozhuang = str_pad(base_convert($this->taozhuang,10,16),2,0,STR_PAD_LEFT);

        $cate = base_convert($this->cate,10,16);

        $pvp = base_convert($this->PVP,10,16);

        $qianghua = str_pad(base_convert($this->qianghua,10,16),2,0,STR_PAD_LEFT);

        $other = "FFFFFFFFFF";


        $code = '0x'.$ItemCode.$Code1.$naijiu.$ItemNums.$excellent.$taozhuang.$cate.$pvp.$qianghua.$other;

//        if($pvp==0)
//        {
//            $pvp='0FFFFFFFFFFff';
//        }
//        if($pvp==1)//PVP
//        {
//            if($this->Type>6 and $this->Type<12)
//            {
//                $pvp='87DFFFFFFFFFF';
//            }
//            else{
//                $pvp='8ADFFFFFFFFFF';
//            }
//
//        }
//        if($pvp==2)
//        {
//            $pvp='005000A10151D';
//        }
//
//        $ItemCode=dechex($this->ZbIndex);
//        if(strlen($ItemCode)==1)
//        {
//            $ItemCode=str_pad($ItemCode,2,"0",STR_PAD_LEFT);
//        }
//        $ItemCk='0x'.$ItemCode.$Code1.dechex($ItemNums).$Code2.dechex($this->Type).$pvp;

        //echo $ItemCk.'->'.strlen($ItemCk).'<br>';
        return $code;
    }

    public function getPrise()
    {
        return $this->Prise;
    }

    public function edit()
    {
//        die($this->skill);
        if($this->validate())
        {
            $this->save();
        }
        else
        {
            return false;
        }
    }

    public function findbyindex($index,$cate){
        return $this->find()->where(['ZbIndex'=>$index,'type'=>$cate])->one();
    }

    public static function typeList($type = array())
    {
        //获取装备分类列表，返回键值对数组
        $lists = self::find()->select('Id,Name,Type,ZbIndex')->where(['Type'=>$type])->asArray()->all();
        $list = ArrayHelper::map($lists,'Id','Name',"Type");
        return $list;
    }

    public function createCode()
    {
        $ItemCode = str_pad(base_convert($this->ZbIndex,10,16),2,0,STR_PAD_LEFT);

        $skill = base_convert($this->skill,10,2);
        $level = str_pad(base_convert($this->level,10,2),4,0,STR_PAD_LEFT);//TODO
        $luck = base_convert($this->luck,10,2);
        $add = str_pad(base_convert($this->add,10,2),2,0,STR_PAD_LEFT);//TODO
        $shuxing = str_pad(base_convert($skill.$level.$luck.$add,2,16),2,0,STR_PAD_LEFT);//shuxing
        $naijiu = str_pad(base_convert($this->naijiu,10,16),2,0,STR_PAD_LEFT);
        $ItemNums = '00000000';
        $excellent = str_pad(base_convert($this->excellent,10,16),2,0,STR_PAD_LEFT);
        $taozhuang = str_pad(base_convert($this->taozhuang,10,16),2,0,STR_PAD_LEFT);
        $cate = base_convert($this->Type,10,16);

        $pvp = base_convert($this->PVP,10,16);
        $qianghua = str_pad(base_convert($this->qianghua,10,16),2,0,STR_PAD_LEFT);
        $other = "FFFFFFFFFF";

        $code = $ItemCode.$shuxing.$naijiu.$ItemNums.$excellent.$taozhuang.$cate.$pvp.$qianghua.$other;
//        var_dump($code);
        return $code;
    }


    public function items_by_type($type_id)
    {
        return $this->find()->where(['Type'=>$type_id])->asArray()->all();
    }


    public function item_info($id){
        return $this->find()->where(['Id'=>$id])->asArray()->one();
    }


    public function itemXY($s_x,$s_y,$return_type = 'string')
    {
        $width = $this->Wide;
        $height = $this->High;
        $arr = array();
        for ($i = 0;$i < $height;$i++)
        {
            for ($t=0;$t<$width;$t++)
            {
                $arr[] = ($s_x+$t)."-".($s_y+$i);
            }
        }

        if($return_type == "array")
        {
            return $arr;
        }
        else
        {
            return implode(",",$arr);
        }

    }






}
