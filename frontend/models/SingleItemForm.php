<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/15
 * Time: 下午5:00
 */

namespace frontend\models;


use common\models\MEMBINFO;
use common\models\Warehouse;
use yii\base\Model;
use common\models\MuItem;
use common\models\ItemLog;
use Yii;

class SingleItemForm extends Model
{

    public $id;
    public $type;
    public $type_list = array(
        '0'=>'剑',
        '1'=>'斧头',
        '2'=>'槌',
        '3'=>'矛',
        '4'=>'弓弩',
        '5'=>'手杖',
        '6'=>'头盔',
        '7'=>'铠甲',
        '8'=>'手套',
        '9'=>'裤子',
        '10'=>'靴子',
        '11'=>'盾牌',
        '12'=>'吊环，饰品',
        '13'=>'珠宝',
        '14'=>'翅膀',
        '15'=>'卷轴，魔法球，消费品',
    );

    public function rules()
    {
        return [
            [['id','type'],'integer'],
            [['id','type'],'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id'=>'装备',
            'type'=>'装备种类',
        ];
    }

    public function buy_item($memb_id){//购买单件装备

        $item = MuItem::findOne(['Id'=>$this->id]);//装备信息
        if(isset($item))
        {
            $menb = MEMBINFO::findOne(['memb___id'=>$memb_id]);
            if($item->Prise>$menb->money){
                return array('code'=>0,'message'=>"您的余额不够，请充值后再进行购买！");
            }

            $code = $item->createCode();//return the string without the "0x"  装备代码，字符串形式返回
            $item_log = new ItemLog();
            $last_sn = $item_log->getLastsn();
            $item_number = str_pad(base_convert($last_sn-1,10,16),8,0,STR_PAD_LEFT);
            $code = substr_replace($code,$item_number,8,8);//最终的装备代码

            $final_str = '';
            $warehouse = new Warehouse();
            $warehouse_code = $warehouse->ItemsCode($memb_id);//返回一个仓库的装备代码块

            if($warehouse_code !== null && (!empty($warehouse_code)))
            {
                $will_space = $warehouse->checkSpace($code,$warehouse_code);//检查这个商品是否能够放进仓库中

                if($will_space['code']===1)//可以放进去仓库中
                {
                    $money_result = $menb->updateMoney($item->Prise,0);//扣钱
                    if($money_result!==true)
                    {
                        return array('code'=>0,'message'=>$money_result);
                    }

                    $final_str = substr_replace($warehouse_code,$code,(($will_space['y']*8 +$will_space['x'])*32),32);
                    $connect = Yii::$app->db;
                    $final_str = "0x".$final_str;
                    $sql = "update warehouse set Items = $final_str where AccountID = '".$memb_id."'";
                    $command = $connect->createCommand($sql);
                    $row = $command->execute();
                    if($row < 1)
                    {
                        return array('code'=>0,'message'=>"购买失败");
                    }
                }
                else
                {
                    return array('code'=>0,'message'=>"仓库空间不足");
                }
            }
            else
            {
                return array('code'=>0,'message'=>"你必须先创建一个角色");
            }



            $item_log->acc = $memb_id;
            $item_log->name = $item->Name;
            $item_log->itemcode = $code;
            $item_log->Iname = $this->type_list[$this->type];
            $item_log->sn = $last_sn-1;
            $item_log->sentdate = date("Y-m-d H:i:s");
            $result = $item_log->save();
            if($result===false)
            {
                return array('code'=>0,'message'=>"记录出现问题，请找客服");
            }
            else
            {
                return array('code'=>1,'message'=>"购买成功");
            }
        }
        else
        {
            return array('code'=>0,'message'=>"未找到该装备");
        }
    }

    public function StrSplit($str,$length=32)//按长度切割字符串
    {
        $str_array = array();
        $str_length = strlen($str);
        while ($str_length)
        {
            $str_array[] = substr($str,0,$length);
            $str = substr($str,$length);
            $str_length = strlen($str);
        }
        return $str_array;
    }
}