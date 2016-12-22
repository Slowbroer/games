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
            'id'=>'id',
            'type'=>'种类',
        ];
    }

    public function buy_item($memb_id){//购买单件装备

//        var_dump($warehouse->AccountID);
        $item = MuItem::findOne(['Id'=>$this->id]);
        if(isset($item))
        {
            $menb = MEMBINFO::findOne(['memb___id'=>$memb_id]);
            if($item->Prise>$menb->money){
                return array(['code'=>0,'message'=>"您的余额不够，请充值后再进行购买！"]);
            }
            else
            {
                $money_result = $menb->updateMoney($item->Prise,0);//update the money
                if($money_result!==true)
                {
                    return array(['code'=>0,'message'=>$money_result]);
                }
            }
            $code = $item->createCode();//return the string without the "0x"
            $item_log = new ItemLog();
            $last_sn = $item_log->getLastsn();
            $item_number = str_pad(base_convert($last_sn-1,10,16),8,0,STR_PAD_LEFT);
            $code = substr_replace($code,$item_number,8,8);

            $change = 0;
            $final_str = '';
            $warehouse = new Warehouse();
            $warehouse_code = $warehouse->ItemsCode($memb_id);
//            var_dump($warehouse_code);
            if($warehouse_code !== null && (!empty($warehouse_code)))
            {
                $will_space = $warehouse->checkSpace($code);
//                var_dump($will_space);
                if($will_space['code']===1)
                {
                    $final_str = substr_replace($warehouse_code,$code,(($will_space['y']*8 +$will_space['x'])*32),32);
                    $connect = Yii::$app->db;
                    $final_str = "0x".$final_str;
                    $sql = "update warehouse set Items = $final_str where AccountID = '".$memb_id."'";
                    $command = $connect->createCommand($sql);
                    $row = $command->execute();
                    if($row < 1)
                    {
                        return array(['code'=>0,'message'=>"购买失败"]);
                    }
                }
//                $str_array = $this->StrSplit($warehouse_code);
//                foreach ($str_array as $key => $value)
//                {
//                    if($value == "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF")
//                    {
//                        $str_array[$key] = $code;
//                        $change += 1;
//                        break;
//                    }
//                }
            }
//            foreach ($str_array as $value)
//            {
//                $final_str .= $value;
//            }
            if($change != 0)
            {
                $connect = Yii::$app->db;
                $final_str = "0x".$final_str;
                $sql = "update warehouse set Items = $final_str where AccountID = '".$memb_id."'";
                $command = $connect->createCommand($sql);
                $row = $command->execute();
                if($row < 1)
                {
                    return array(['code'=>0,'message'=>"购买失败"]);
                }
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