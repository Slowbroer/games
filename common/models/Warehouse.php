<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property string $AccountID
 * @property resource $Items
 * @property integer $Money
 * @property string $EndUseDate
 * @property integer $DbVersion
 * @property integer $pw
 * @property integer $ExtCKNum
 * @property integer $NeedExtCK
 */
class Warehouse extends \yii\db\ActiveRecord
{

    public $used_space = array();
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AccountID'], 'required'],
            [['AccountID', 'Items'], 'string'],
            [['Money', 'DbVersion', 'pw', 'ExtCKNum', 'NeedExtCK'], 'integer'],
            [['EndUseDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AccountID' => 'Account ID',
            'Items' => 'Items',
            'Money' => 'Money',
            'EndUseDate' => 'End Use Date',
            'DbVersion' => 'Db Version',
            'pw' => 'Pw',
            'ExtCKNum' => 'Ext Cknum',
            'NeedExtCK' => 'Need Ext Ck',
        ];
    }

    public static function getinfo($id){
        return self::findOne(['AccountID'=>$id]);
    }


    public function updateItem($code)
    {
        $this->Items = $code;
        return $this->save()? true:false;
    }

    public function UsedSpace($item)//获取到仓库的已经使用的格子，以数组的形式返回,参数为仓库中的装备代码
    {
        preg_match_all("/[0-9a-fA-F]{32}/",$item,$items_code);
        $used_space = array();

        foreach ($items_code[0] as $key => $value)
        {
            if(!preg_match("/^[F|f]+$/",$value))
            {

                $Index_code = hexdec(substr($value,0,2));
                $cate		= hexdec(substr($value,18,1));

                $item = new MuItem();
                $item_info = $item->findbyindex($Index_code,$cate);
                $used_space[] = $item_info->itemXY($key%8,intval($key/8),"string");
            }
        }
        if(!empty($used_space))
        {
            $used_space = explode(",",implode(",",$used_space));
        }
        return $used_space;
    }

    public function checkSpace($item_code='',$warehouse_item)//检查仓库是否有空位置给一个装备放置，如果有，返回这个位置的坐标信息
    {
        if(empty($item_code)||preg_match("/^[F|f]+$/",$item_code))
        {
            return true;
        }
        else
        {
            $Index_code = hexdec(substr($item_code,0,2));
            $cate		= hexdec(substr($item_code,18,1));
            $item = new MuItem();
            $item_info = $item->findbyindex($Index_code,$cate);

            $will_space =array('code'=>0);
            $used_space = empty($this->used_space)? $this->UsedSpace($warehouse_item):$this->used_space;//get the used space of warehouse

            for ($y = 0;$y < 15;$y++)//遍历每一个格子，检测是否能够放置这件装备
            {
                for ($x = 0;$x < 8;$x++)
                {
                    $space = $x."-".$y;
                    if(!in_array($space,$used_space))
                    {
                        $item_space = $item_info->itemXY($x,$y,"array");
                        $is_used = false;
                        foreach ($item_space as $key=>$value)
                        {
                            $xy = explode("-",$value);
                            if($xy[0] >=8 || $xy[1] >= 15 || in_array($value,$used_space))
                            {
                                $is_used = true;
                                break;
                            }
                        }
                        if($is_used == false)
                        {
                            $will_space['code'] = 1;
                            $will_space['x'] = $x;
                            $will_space['y'] = $y;
                            return $will_space;
                        }
                    }
                }
            }
            return $will_space;
        }
    }

    public function ItemsCode($memb_id='')//获取仓库的装备代码，已经转换为字符串的
    {
        if(empty($memb_id))
        {
            $memb_id = $this->AccountID;
        }
        if(empty($memb_id))
        {
            return null;
        }

        $item = $this->find()->select(" DBO.varbin2hexstr(Items) as item ")->where(['AccountID'=>$memb_id])->asArray()->one();
        return $item['item'];
    }


    public function register_add(MEMBINFO $user)
    {
        $this->AccountID = $user->memb___id;
        $this->save();
    }






}
