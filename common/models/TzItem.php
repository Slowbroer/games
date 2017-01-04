<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "TzItem".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $BW
 * @property integer $Prise
 * @property string $ItemNums
 * @property string $zuoshou
 * @property string $tou
 * @property string $kai
 * @property string $shou
 * @property string $tui
 * @property string $xie
 * @property string $xianglian
 * @property string $zuojiezhi
 */
class TzItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TzItem';
    }

    public $item_types = array(
        'zuoshou'=>['name'=>'左手','id'=>['0','1','2','3','4','5']],
        'youshou'=>['name'=>'右手','id'=>['0','1','2','3','4','5']],
        'tou'=>['name'=>'头盔','id'=>[7]],
        'kai'=>['name'=>'铠甲','id'=>[8]],
        'shou'=>['name'=>'手','id'=>[10]],
        'tui'=>['name'=>'腿','id'=>[9]],
        'xie'=>['name'=>'鞋子','id'=>[11]],
        'xianglian'=>['name'=>'项链','id'=>[13]],
        'zuojiezhi'=>['name'=>'左戒指','id'=>[1]],
        'youjiezhi'=>['name'=>'右戒指','id'=>[1]],

    );

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'BW', 'ItemNums', 'zuoshou', 'tou', 'kai', 'shou', 'tui', 'xie', 'xianglian', 'zuojiezhi'], 'string'],
            [['Prise'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Name' => '名字',
            'BW' => 'Bw',
            'Prise' => '价格',
            'ItemNums' => 'Item Nums',
            'zuoshou' => 'Zuoshou',
            'tou' => 'Tou',
            'kai' => 'Kai',
            'shou' => 'Shou',
            'tui' => 'Tui',
            'xie' => 'Xie',
            'xianglian' => 'Xianglian',
            'zuojiezhi' => 'Zuojiezhi',
        ];
    }


    public function package_list()
    {
        return $this->find()->select("*")->asArray()->all();
    }

    public static function lists(){
        return self::find()->select("*")->asArray()->all();
    }

    public function info($id){
        return $this->find()->where(['Id'=>$id])->asArray()->one();
    }


    public function savePackage($memb_id,$space_enough,$warehouse_items=''){

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
        foreach ($this->attributes as $key=>$value)
        {
            if($key!='Id'&&$key!='Name'&&$key!='BW'&&$key!='Prise'&&$key!='ItemNums')
            {
                if(($value!=null) && (!preg_match("/^[f|F]+$/",$value))){
                    $item_log = new ItemLog();
                    $sn = $item_log->getLastsn();
                    $item_number = str_pad(base_convert($sn-1,10,16),8,0,STR_PAD_LEFT);
                    $item_code = substr_replace($value,$item_number,8,8);

                    $warehouse_items = substr_replace($warehouse_items,$item_code,(($space_enough[$key]['y']*8 +$space_enough[$key]['x'])*32),32);

                    $item_log->acc = $memb_id;
                    $item_log->name = $this->Name;
                    $item_log->itemcode = $item_code;
                    $item_log->Iname = "套装";
                    $item_log->sn = $sn-1;
                    $item_log->sentdate = date("Y-m-d H:i:s");
                    $result = $item_log->save();
                    if($result===false)
                    {
                        return false;
                    }
                }
            }
        }

        $connect = Yii::$app->db;
        $warehouse_items = "0x".$warehouse_items;
        $sql = "update warehouse set Items = $warehouse_items where AccountID = '".$memb_id."'";
//        $sql = "update warehouse set Items= DBO.ItemCode(".$array['zuoshou'].",".$array['youshou'].","
//            .$array['tou'].",".$array['kai'].","
//            .$array['shou'].",".$array['tui'].","
//            .$array['xie'].",".$array['fei'].",".$array['xianglian'].","
//            .$array['zuojiezhi'].",".$array['youjiezhi']
//            .") where AccountID = '".$memb_id."'";

        $command = $connect->createCommand($sql);
        $code = $command->execute();

        return $code;
    }

    public function package_update(){
        if(!$this->validate())
        {
            return false;
        }
        else
        {
            return $this->save();
        }
    }

    //获取套装中的装备，解析套装中的装备代码，然后以数组的形式返回
    public function getItem(){
        $items = array();
        foreach ($this->attributes as $key=>$value)
        {
//            var_dump($value);
            if($key!='Id'&&$key!='Name'&&$key!='BW'&&$key!='Prise'&&$key!='ItemNums')
            {
                if($value!=null&&$value!='FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF')
                {
                    $index = base_convert(substr($value,0,2),16,10);//排序

                    $items[$key]['ZbIndex'] = $index;
                    $items[$key]['shuxing'] = substr($value,2,2);//属性，需要进一步细化
                    $shuxing = str_pad(base_convert($items[$key]['shuxing'],16,2),8,0,STR_PAD_LEFT);
                    $items[$key]['skill'] = substr($shuxing,0,1);
                    $items[$key]['level'] = bindec(substr($shuxing,1,4));//bin to 10
                    $items[$key]['luck'] = substr($shuxing,5,1);
                    $items[$key]['add'] = bindec(substr($shuxing,6,2));

                    $items[$key]['naijiu'] = base_convert(substr($value,4,2),16,10);//耐久
                    $items[$key]['excellent'] = base_convert(substr($value,14,2),16,10);//卓越
                    $items[$key]['taozhuang'] = base_convert(substr($value,16,2),16,10);//套装
                    $items[$key]['cate'] = base_convert(substr($value,18,1),16,10);//装备大类
                    $items[$key]['PVP'] = base_convert(substr($value,19,1),16,10);//pvp
                    $items[$key]['qianghua'] = base_convert(substr($value,20,2),16,10);//强化
                    $items[$key]['type_name'] = $this->item_types[$key]['name'];

                    $item = new MuItem();
                    $item_info = $item->findbyindex($index,$items[$key]['cate']);
                    $items[$key]['Name'] = $item_info['Name'];
                    $items[$key]['Id'] = $item_info['Id'];

                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);

//                    $item = new MuItem();
//                    $item_info = $item->findbyindex(base_convert(substr($value,0,2),16,10),base_convert(substr($value,18,1),16,10));
//
//                    $items[$key]['item'] = $item_info;
//                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);
//                    $items[$key]['type_name'] = $this->item_types[$key]['name'];
                }
                else
                {
                    $items[$key]['ZbIndex'] = -1;
                    $items[$key]['shuxing'] = 0;
                    $items[$key]['skill'] = 0;
                    $items[$key]['level'] = 0;
                    $items[$key]['luck'] = 0;
                    $items[$key]['add'] = 0;
                    $items[$key]['naijiu'] = 0;
                    $items[$key]['excellent'] = 0;
                    $items[$key]['taozhuang'] = 0;
                    $items[$key]['cate'] = 0;
                    $items[$key]['PVP'] = 0;
                    $items[$key]['qianghua'] = 0;
                    $items[$key]['Name'] = '';
                    $items[$key]['type_name'] = $this->item_types[$key]['name'];
                    $items[$key]['Id'] = 0;
//                    $items[$key]['type_id'] = $this->item_types[$key]['id'];
                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);

//                    $items[$key]['item'] = new MuItem();
//                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);
//                    $items[$key]['type_name'] = $this->item_types[$key]['name'];
                }
            }
        }
        return $items;
    }


    public function space_enough($used_space)
    {
        $space_enough = array('code'=>1);
        foreach ($this->attributes as $key => $value)//遍历每一件装备
        {
            if($key!='Id'&&$key!='Name'&&$key!='BW'&&$key!='Prise'&&$key!='ItemNums')
            {
                if(!preg_match("/^[f|F]+$/",$value))
                {
                    $Index_code = hexdec(substr($value,0,2));
                    $cate		= hexdec(substr($value,18,1));

                    $item = new MuItem();
                    $item_info = $item->findbyindex($Index_code,$cate);

                    $item_enough = true;
                    $space_enough[$key]=array();
                    for ($y = 0;$y < 15;$y++)//遍历每一个格子，检测是否能够放置这件装备
                    {
                        for ($x = 0;$x < 8;$x++)
                        {
                            $space = $x."-".$y;
                            if(!in_array($space,$used_space))
                            {
                                $item_space = $item_info->itemXY($x,$y,"array");
                                $is_used = false;
                                foreach ($item_space as $k=>$v)
                                {
                                    $xy = explode("-",$v);
                                    if($xy[0] >=8 || $xy[1] >= 15 || in_array($v,$used_space))
                                    {
                                        $is_used = true;
                                        break;
                                    }
                                }
                                if($is_used == false)//如果这件装备能放进去
                                {
                                    $space_enough[$key]['x'] = $x;
                                    $space_enough[$key]['y'] = $y;
                                    $used_space = array_merge($used_space,$item_space);
                                    break 2;
                                }
                                else
                                {
                                    continue;//如果放不进去，继续遍历格子
                                }
                            }
                        }
                    }
                    if(empty($space_enough[$key]))
                    {
                        $space_enough['code'] = 0;//有一件装备不能放进去就退出，说明套装放不进去
                        break;
                    }
                }
                else
                {
                    continue;
                }
            }
        }
        return $space_enough;
    }


}
