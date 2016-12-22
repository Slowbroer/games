<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/19
 * Time: ÏÂÎç9:00
 */

namespace frontend\models;


use common\models\ItemLog;
use common\models\MEMBINFO;
use common\models\MuItem;
use common\models\Warehouse;
use yii\base\Model;
use Yii;

class ItemForm extends Model
{

    public $zuoshou;
    public $youshou;
    public $tou;
    public $kai;
    public $shou;
    public $tui;
    public $xie;
    public $fei;
    public $xianglian;
    public $zuoshouzhi;
    public $youshouzhi;


    public function rules()
    {

        return [
            [['zuoshou','youshou','tou','kai','shou','tui','xie','fei','xianglian','zuoshouzhi','zuoshouzhi'],'string','message'=>"选项为无效值"],
            [['zuoshou','youshou','tou','kai','shou','tui','xie','fei','xianglian','zuoshouzhi','zuoshouzhi'],'exist',
                'targetClass' => '\common\models\MuItem', 'targetAttribute'=>'Name','message'=>"无效的装备，请重新选择"],
        ];
    }


    public function attributeLabels()
    {
        return [
            'zuoshou' => '左手',
            'youshou' => '右手',
            'tou' => '头',
            'kai' => '铠甲',
            'shou' => '守护',
            'tui' => '腿',
            'xie' => '鞋',
            'fei' => '飞',
            'xianglian' => '项链',
            'zuoshouzhi' => '左手指',
            'youshouzhi' => '右手指',
        ];
    }

    public function getItem($memb_id){
        if(!$this->validate())
        {
            return false;
        }


//        $lefthand_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $righthand_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $tou_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $kai_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $shou_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $tui_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $xie_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $fei_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $xianglian_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $zuojiezhi_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
//        $youjiezhi_code = '0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';

        $message = "";
        $menb = MEMBINFO::findOne(['memb___id'=>$memb_id]);
        $money = 0;
        foreach ($this->attributes as $item)
        {
            $i = MuItem::findOne(['Name'=>$item]);//get a item
            if(isset($i))
            {
                $money += $i->Prise;
            }
        }
        if($money>$menb->money){
            return "您的余额不够，请充值后再进行购买！";
        }
        else
        {
            $money_result = $menb->updateMoney($money,0);//update the money
            if($money_result!==true)
            {
                return $money_result;
            }
        }

        $array = array(
            'zuoshou'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'youshou'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'kai'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'tou'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'shou'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'tui'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'xie'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'xianglian'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'zuojiezhi'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'youjiezhi'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
            'fei'=>'0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',
        );

        foreach ($this->attributes as $key => $value)
        {
            if(!empty($value))
            {
                $item = MuItem::findOne(['Name'=>$value]);
                if(isset($item))
                {
                    $code = $item->createCode();//return the string without the "0x"
                    $item_log = new ItemLog();
                    $last_sn = $item_log->getLastsn();
                    $item_number = str_pad(base_convert($last_sn-1,10,16),8,0,STR_PAD_LEFT);
                    $array[$key] = "0x".substr_replace($code,$item_number,8,8);

                    $item_log->acc = $memb_id;
                    $item_log->name = $item->Name;
                    $item_log->itemcode = $array[$key];
                    $item_log->Iname = $this->attributeLabels()[$key];
                    $item_log->sn = $last_sn-1;
                    $item_log->sentdate = date("Y-m-d H:i:s");
                    $result = $item_log->save();
                    if($result===false)
                    {
                        return array('code'=>0,'message'=>"记录出现问题，请找客服");
                    }
                }
                else
                {
                    return array('code'=>0,'message'=>"未找到该装备");
                }
            }
        }

        $connect = Yii::$app->db;
        $sql = "update warehouse set Items= DBO.ItemCode(".$array['zuoshou'].",".$array['youshou'].","
            .$array['tou'].",".$array['kai'].","
            .$array['shou'].",".$array['tui'].","
            .$array['xie'].",".$array['fei'].",".$array['xianglian'].","
            .$array['zuojiezhi'].",".$array['youjiezhi']
            .") where AccountID = '".$memb_id."'";
        $command = $connect->createCommand($sql);
        $code = $command->execute();
        if($code > 0)
        {
            return array('code'=>1,'message'=>"购买成功");
        }
        else
        {
            return array('code'=>0,'message'=>"购买失败");
        }

//        if(!empty($this->zuoshou))
//        {
//            $lefthand = MuItem::findOne(['Name'=>$this->zuoshou]);//get a item
//            $code1 = 'EFFF';
//            $code2 = '7F00';
//
//            $pvp=0;    //PVP
//            if($lefthand['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($lefthand['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($lefthand['XQ']=='0' and $lefthand['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $lefthand_code = $lefthand->getCode($ItemNums,$code1,$code2,$pvp);
////            return $lefthand_code;
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买左手装备',
//                'itemcode'=>$lefthand_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$lefthand['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//
//        if(!empty($this->youshou))
//        {
//            $code1='EFFF';
//            $code1='7F00';
//
//            $righthand = MuItem::findOne(['Name'=>$this->youshou]);
//            $pvp=0;    //PVP
////            if($righthand['PVP']=='1')  //pvp
////            {
////                $pvp=1;
////            }
////            if($righthand['XQ']=='1') //镶嵌
////            {
////                $pvp=2;
////            }
////            if($righthand['XQ']=='0' and $righthand['PVP']=='0') //普通
////            {
////                $pvp=0;
////            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $righthand_code = $righthand->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买右手装备',
//                'itemcode'=>$righthand_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$righthand['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->tou))
//        {
//            $code1 = '6FFF';
//            $code2 = '7F00';
//
//            $tou = MuItem::findOne(['Name'=>$this->tou]);
//            $pvp=0;    //PVP
//            if($tou['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($tou['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($tou['XQ']=='0' and $tou['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $tou_code = $tou->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买头装备',
//                'itemcode'=>$tou_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$tou['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->kai))
//        {
//            $code1 = '6FFF';
//            $code2 = '7F00';
//
//            $kai = MuItem::findOne(['Name'=>$this->kai]);
//            $pvp=0;    //PVP
//            if($kai['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($kai['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($kai['XQ']=='0' and $kai['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $kai_code = $kai->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买铠甲装备',
//                'itemcode'=>$kai_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$kai['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->shou))
//        {
//            $code1 = '6FFF';
//            $code2 = '7F00';
//
//            $shou = MuItem::findOne(['Name'=>$this->shou]);
//            $pvp=0;    //PVP
//            if($shou['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($shou['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($shou['XQ']=='0' and $kai['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $shou_code = $shou->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买守备装备',
//                'itemcode'=>$shou_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$shou['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->tui))
//        {
//            $code1 = '6FFF';
//            $code2 = '7F00';
//
//            $tui = MuItem::findOne(['Name'=>$this->tui]);
//            $pvp=0;    //PVP
//            if($tui['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($tui['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($tui['XQ']=='0' and $tui['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $tui_code = $tui->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买铠甲装备',
//                'itemcode'=>$tui_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$tui['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->xie))
//        {
//            $code1 = '6FFF';
//            $code2 = '7F00';
//
//            $xie = MuItem::findOne(['Name'=>$this->xie]);
//            $pvp=0;    //PVP
//            if($xie['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($xie['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($xie['XQ']=='0' and $xie['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $xie_code = $xie->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买鞋装备',
//                'itemcode'=>$xie_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$xie['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->fei))
//        {
//            $code1 = '6FFF';
//            $code2 = '7F00';
//
//            $fei = MuItem::findOne(['Name'=>$this->fei]);
//            $pvp=0;    //PVP
//            if($fei['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($fei['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($fei['XQ']=='0' and $fei['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $fei_code = $fei->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买飞行装备',
//                'itemcode'=>$fei_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$fei['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->xianglian))
//        {
//            $code1 = '6BFF';
//            $code2 = '7F00';
//
//            $xianglian = MuItem::findOne(['Name'=>$this->xianglian]);
//            $pvp=0;    //PVP
//            if($xianglian['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($xianglian['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($xianglian['XQ']=='0' and $xianglian['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $xianglian_code = $xianglian->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买项链装备',
//                'itemcode'=>$xianglian_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$xianglian['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->zuojiezhi))
//        {
//            $code1 = '6BFF';
//            $code2 = '7F00';
//
//            $zuojiezhi = MuItem::findOne(['Name'=>$this->zuojiezhi]);
//            $pvp=0;    //PVP
//            if($zuojiezhi['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($zuojiezhi['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($zuojiezhi['XQ']=='0' and $zuojiezhi['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $zuojiezhi_code = $zuojiezhi->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买左戒指装备',
//                'itemcode'=>$zuojiezhi_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$zuojiezhi['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }
//        if(!empty($this->youjiezhi))
//        {
//            $code1 = '6BFF';
//            $code2 = '7F00';
//
//            $youjiezhi = MuItem::findOne(['Name'=>$this->youjiezhi]);
//            $pvp=0;    //PVP
//            if($youjiezhi['PVP']=='1')  //pvp
//            {
//                $pvp=1;
//            }
//            if($youjiezhi['XQ']=='1') //镶嵌
//            {
//                $pvp=2;
//            }
//            if($youjiezhi['XQ']=='0' and $youjiezhi['PVP']=='0') //普通
//            {
//                $pvp=0;
//            }
//
//            $item_log= new ItemLog();//'select min(sn) as maxvalue from ItemLog';
//            $arry=$item_log->getLastsn();
//            $ItemNums=$arry-1; //序号   get the last sn-1
//
//            $youjiezhi_code = $youjiezhi->getCode($ItemNums,$code1,$code2,$pvp);
//
//            $ItemArry=array(
//                'acc'=>$memb_id,
//                'name'=>'购买左戒指装备',
//                'itemcode'=>$youjiezhi_code,
//                'sn'=>$ItemNums,
//                'Iname'=>$youjiezhi['Name'],
//                'sentdate'=>date("Y-m-d H:i:s"),
//            );
//            $item_log->add_log($ItemArry);
//        }

//        $connect = Yii::$app->db;
//        $sql = "select DBO.varbin2hexstr(DBO.ItemCode($lefthand_code,$righthand_code,$tou_code,
//        $kai_code,$shou_code,$tui_code,$xie_code,
//        $fei_code,$xianglian_code,$zuojiezhi_code,
//        $youjiezhi_code)) as code";
//        $sql = "update warehouse set Items= DBO.ItemCode($lefthand_code,$righthand_code,$tou_code,
//        $kai_code,$shou_code,$tui_code,$xie_code,
//        $fei_code,$xianglian_code,$zuojiezhi_code,
//        $youjiezhi_code) where AccountID = '".$memb_id."'";
//        $command = $connect->createCommand($sql);
//        $code = $command->queryScalar();
//        $code = $command->execute();
//
//        return $code;




//        $warehouse = Warehouse::findOne(['AccountID'=>$memb_id]);
//        if(isset($warehouse))
//        {
//            $warehouse->Items = $code;
//            return $warehouse->save();
//        }
//        return false;
    }


    public function BinToStr($str){
        $arr = explode(' ', $str);
        foreach($arr as &$v){
            $v = pack("H".strlen(base_convert($v, 2, 16)), base_convert($v, 2, 16));
        }

        return join('', $arr);
    }


}
