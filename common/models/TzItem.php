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


    public function savePackage($memb_id){

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
                if($value!=null){
                    $item_log = new ItemLog();
                    $sn = $item_log->getLastsn();
                    $item_number = str_pad(base_convert($sn-1,10,16),8,0,STR_PAD_LEFT);
                    $array[$key] = "0x".substr_replace($value,$item_number,8,8);

                    $item_log->acc = $memb_id;
                    $item_log->name = $this->Name;
                    $item_log->itemcode = $array[$key];
                    $item_log->Iname = "套装";
                    $item_log->sn = $sn-1;
                    $item_log->sentdate = date("Y-m-d H:i:s");
                    $result = $item_log->save();
                    if($result===false)
                    {
                        return false;
                    }

//                    $this->attributes[$key] = substr_replace($value,$item_number,6,8);
//                    $item_log->setAttribute($key,substr_replace($value,$item_number,6,8));
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
//        die($sql);

        $command = $connect->createCommand($sql);
        $code = $command->execute();
//        $result = '';
//        foreach ($array as $value)
//        {
//            $result .= $value;
//        }
//        $result = str_pad($result,120*32,"F",STR_PAD_RIGHT);

//        $connect = Yii::$app->db;
//
//                $sql = "select DBO.varbin2hexstr(DBO.ItemCode(".$array['zuoshou'].",".$array['youshou'].","
//                    .$array['tou'].",".$array['kai'].","
//                    .$array['shou'].",".$array['tui'].","
//                    .$array['xie'].",".$array['fei'].",".$array['xianglian'].","
//                    .$array['zuojiezhi'].",".$array['youjiezhi']
//                    .")) as code";
//
//                $command = $connect->createCommand($sql);
//                $code = $command->queryScalar();

        return $code;

//        var_dump($this->attributes['zuoshou']);
//        array (size=13)
//      'Id' => int 2
//      'Name' => string '战士王者大天套' (length=21)
//      'BW' => string '（大天使之剑+火之项链）' (length=34)
//      'Prise' => int 200
//      'ItemNums' => string '5' (length=1)
//      'zuoshou' => string '13EFC8FFFFFFC97F0900ADFFFFFFFFFF' (length=32)
//      'tou' => null
//      'kai' => null
//      'shou' => null
//      'tui' => null
//      'xie' => null
//      'xianglian' => string '0D6B66FFFFFFC87F0AD0ADFFFFFFFFFF' (length=32)
//      'zuojiezhi' => null
    }

    public function package_update(){
        if(!$this->validate())
        {
            return false;
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
//                    $index = base_convert(substr($value,0,2),16,10);//排序
//
//                    $items[$key]['ZbIndex'] = $index;
//                    $items[$key]['shuxing'] = substr($value,2,2);//属性，需要进一步细化
//                    $shuxing = str_pad(base_convert($items[$key]['shuxing'],16,2),8,0,STR_PAD_LEFT);
//                    $items[$key]['skill'] = substr($shuxing,0,1);
//                    $items[$key]['level'] = bindec(substr($shuxing,1,4));//bin to 10
//                    $items[$key]['luck'] = substr($shuxing,5,1);
//                    $items[$key]['add'] = bindec(substr($shuxing,6,2));
//
//                    $items[$key]['naijiu'] = base_convert(substr($value,4,2),16,10);//耐久
//                    $items[$key]['excellent'] = base_convert(substr($value,14,2),16,10);//卓越
//                    $items[$key]['taozhuang'] = base_convert(substr($value,16,2),16,10);//套装
//                    $items[$key]['cate'] = base_convert(substr($value,18,1),16,10);//装备大类
//                    $items[$key]['PVP'] = base_convert(substr($value,19,1),16,10);//pvp
//                    $items[$key]['qianghua'] = base_convert(substr($value,20,2),16,10);//强化
//                    $items[$key]['type_name'] = $this->item_types[$key]['name'];
//
//                    $item = new MuItem();
//                    $item_info = $item->findbyindex($index,$items[$key]['cate']);
//                    $items[$key]['Name'] = $item_info['Name'];
//                    $items[$key]['Id'] = $item_info['Id'];
//
//                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);

                    $item = new MuItem();
                    $item_info = $item->findbyindex(base_convert(substr($value,0,2),16,10),base_convert(substr($value,18,1),16,10));

                    $items[$key]['item'] = $item_info;
                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);
                    $items[$key]['type_name'] = $this->item_types[$key]['name'];
                }
                else
                {
//                    $items[$key]['ZbIndex'] = -1;
//                    $items[$key]['shuxing'] = 0;
//                    $items[$key]['skill'] = 0;
//                    $items[$key]['level'] = 0;
//                    $items[$key]['luck'] = 0;
//                    $items[$key]['add'] = 0;
//                    $items[$key]['naijiu'] = 0;
//                    $items[$key]['excellent'] = 0;
//                    $items[$key]['taozhuang'] = 0;
//                    $items[$key]['cate'] = 0;
//                    $items[$key]['PVP'] = 0;
//                    $items[$key]['qianghua'] = 0;
//                    $items[$key]['Name'] = '';
//                    $items[$key]['type_name'] = $this->item_types[$key]['name'];
//                    $items[$key]['Id'] = 0;
////                    $items[$key]['type_id'] = $this->item_types[$key]['id'];
//                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);

                    $items[$key]['item'] = new MuItem();
                    $items[$key]['type_list'] = MuItem::typeList($this->item_types[$key]['id']);
                    $items[$key]['type_name'] = $this->item_types[$key]['name'];
                }
            }
        }
        return $items;
    }


}
