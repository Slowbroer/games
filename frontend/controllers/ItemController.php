<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/20
 * Time: ÉÏÎç12:29
 */

namespace frontend\controllers;



use common\models\Announcement;
use common\models\MEMBINFO;
use common\models\MEMBSTAT;
use common\models\MuItem;
use common\models\TzItem;
use common\models\Warehouse;
use frontend\models\ItemForm;
use frontend\models\PackageForm;
use frontend\models\SingleItemForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;

class ItemController extends Controller
{


    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=>['buyitem','buypackage'],
                'rules'=>[
                    [
                        'allow' => true,
                        'actions' => ['buyitem', 'buypackage', 'buy_single_item' ],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    public function actionBuyitem(){

        $model = new ItemForm();

        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $online = MEMBSTAT::connect_stat(Yii::$app->user->identity->getMenb());
            if($online==1)
            {
                return $this->render('/site/error',['message'=>'你现在处于在线状态，请离线后进行购买！']);
            }

            $warehouse = Warehouse::getinfo(Yii::$app->user->identity->getMenb());

            if(empty($warehouse['Items']))
            {
                return $this->render('/site/error',['message'=>'购买失败！购买装备之前必须建立角色并且打开仓库一次！否则无法购买哦！']);
            }

            $mem_id = Yii::$app->user->identity->getMenb();
            $connect = Yii::$app->db;
            $sql = "select DBO.JC_CKZB_NUM('".$mem_id."') as id";
            $command = $connect->createCommand($sql);
            $code = $command->queryScalar();
            if($code!=0)
            {
                return $this->render('/site/error',['message'=>'检测到您的仓库有'.$code.'件物品，请取出再进行购买']);
            }

            $result = $model->getItem(Yii::$app->user->identity->getMenb());
            if($result['code']==0)
            {
                return $this->render('/site/error',['message'=>$result['message']]);
            }
            else{
//                $warehouse->Items = $code;
//                $warehouse->updateItem($code);
                return $this->render('/site/success',['message'=>$result['message'],'name'=>"购买装备"]);
            }
        }
        else
        {

            $items = MuItem::find()->select("Name,Type,Prise,Id")->asArray()->all();

            foreach ($items as $key=>$item)
            {
                $items[$key]['Prise'] = $item['Name']."(".$item['Prise']."元宝)";
            }

            $item_list = ArrayHelper::map($items,'Name','Prise','Type');

            echo $this->render("buy",[
                'model'=>$model,
                'list'=>$item_list,
            ]);
        }
    }

    //购买套装
    public function actionBuypackage(){

        $id = isset($_POST['id'])? $_POST['id']:0;
        $package = TzItem::findOne(['Id'=>$id]);
        $lists = TzItem::lists();

        if(isset($package))
        {
            if(Yii::$app->user->isGuest)
            {
                return $this->render('/site/error',['message'=>'请先登陆']);
            }

            $mem_id = Yii::$app->user->identity->getMenb();
            $online = MEMBSTAT::connect_stat($mem_id);
            if($online==1)
            {
                return $this->render('/site/error',['message'=>'你现在处于在线状态，请离线后进行购买！']);
            }
            if(!isset($package))
            {
                return $this->render('/site/error',['message'=>'未找到相应的套装，请重新刷新页面或者联系客服']);
            }

            $warehouse = Warehouse::getinfo(Yii::$app->user->identity->getMenb());
            if(empty($warehouse['Items']))
            {
                return $this->render('/site/error',['message'=>'购买失败！购买装备之前必须建立角色并且打开仓库一次！否则无法购买哦！']);
            }

            $connect = Yii::$app->db;
            $sql = "select DBO.JC_CKZB_NUM('".$mem_id."') as id";
            $command = $connect->createCommand($sql);
            $code = $command->queryScalar();
            if($code!=0)
            {
                return $this->render('/site/error',['message'=>'检测到您的仓库有'.$code.'件物品，请取出再进行购买']);
            }

            $memb_info = MEMBINFO::findOne(['memb___id'=>$mem_id]);
            if($memb_info->money<$package->Prise)
            {
                return $this->render('/site/error',['message'=>'您的余额不足，请先充值之后进行购买']);
            }

            $item = $warehouse->ItemsCode();
            $used_space = $warehouse->UsedSpace($item);
            $space_enough = $package->space_enough($used_space);
            if($space_enough['code']==0)
            {
                return $this->render('/site/error',['message'=>"仓库的空间不足，请整理仓库之后再进行购买"]);
            }


            $result = $memb_info->updateMoney($package->Prise,0);//扣除金额
            if($result!==true)
            {
                return $this->render('/site/error',['message'=>$result]);
            }

            $result = $package->savePackage($mem_id,$space_enough,$item);//记录购买记录和返回记录到仓库的装备代码
            if($result>=0)
            {
                return $this->render('/site/success',['message'=>'购买成功，请到游戏里查看','name'=>"购买套装"]);
            }
            else
            {
                return $this->render('/site/error',['message'=>"写入失败，请联系客服"]);
            }
        }
        echo $this->render('package',['lists'=>$lists,'title'=>'购买套装']);
        exit;
    }

    public function actionPackageinfo(){
        $id = isset($_POST['id'])? $_POST['id']:0;
        if(!empty($id))
        {
            $package = new TzItem();
            $info = $package->info($id);
            if(!empty($info))
            {
                $content = $this->renderPartial("package_info",['info'=>$info]);
                return json_encode(array('code'=>1,'message'=>$content));
            }
            else
            {
                return json_encode(array('code'=>0,'message'=>"未找到相应的套装，请重新选择"));
            }
        }
        else
        {
            return json_encode(array('code'=>0,'message'=>"未找到相应的套装，请刷新页面"));
        }

    }






    public function actionBuy_single_item()
    {
        if (Yii::$app->user->isGuest)
        {
            return $this->render("/site/error",['message'=>'您还没登陆']);
        }
        $model = new SingleItemForm();
        if($model->load(Yii::$app->request->post())&&$model->validate())
        {
            $memb_id = Yii::$app->user->identity->getMenb();
            $online = MEMBSTAT::connect_stat($memb_id);
            if($online==1)
            {
                return $this->render('/site/error',['message'=>'你现在处于在线状态，请离线后进行购买！']);
            }

            $warehouse = Warehouse::getinfo(Yii::$app->user->identity->getMenb());

            if(empty($warehouse['Items']))
            {
                return $this->render('/site/error',['message'=>'购买失败！购买装备之前必须建立角色并且打开仓库一次！否则无法购买哦！']);
            }
            
            $connect = Yii::$app->db;
            $sql = "select DBO.JC_CKZB_NUM('".$memb_id."') as id";
            $command = $connect->createCommand($sql);
            $code = $command->queryScalar();
            if($code!=0)
            {
                return $this->render('/site/error',['message'=>'检测到您的仓库有'.$code.'件物品，请取出再进行购买']);
            }

            $result = $model->buy_item($memb_id);
            if($result['code']==0)
            {
                return $this->render('/site/error',['message'=>$result['message']]);
            }
            else{
//                $warehouse->Items = $code;
//                $warehouse->updateItem($code);
                return $this->render('/site/success',['message'=>$result['message'],'name'=>"购买装备"]);
            }

        }
        else
        {
            $lists = $model->type_list;
            echo $this->render("buy_item",['lists'=>$lists,'model'=>$model]);
        }
    }

    public function actionItem_type(){
        $type_id = isset($_GET['type_id'])? $_GET['type_id']:null;
        if($type_id === null)
        {
            return false;
        }
        else
        {
            $item = new MuItem();
            $lists = $item->items_by_type($type_id);

            $lists = ArrayHelper::map($lists,'Id','Name');
            return json_encode($lists);

//            return json_encode(array('1'=>'test','2'=>'test'));
        }
    }

    public function actionItem_info(){
        $id = isset($_GET['id'])? $_GET['id']:null;
        if($id === null)
        {
            return false;
        }
        else
        {
            $item = new MuItem();
            $info = $item->item_info($id);
            return json_encode($info);
        }
    }


    public function actionTest()
    {
//        $men = new MEMBINFO();
//        $money = $men->getmoney("zhang004");
//        var_dump($money);


//        $tz = TzItem::findOne(['Id'=>2]);
//        $tz->savePackage();
        $wearhouse = Warehouse::findOne(['AccountID'=>'zhang004']);
//
        $item = $wearhouse->ItemsCode();
        var_dump($item);
//        $items_code = array();
//        preg_match_all("/[0-9a-fA-F]{32}/",$item,$items_code);
//        var_dump($items_code);
//        $item = new MuItem();
//        $item_info = $item->findbyindex(2,3);
//        var_dump($item_info);

//        $item = $wearhouse->UsedSpace();
//        var_dump(strlen($item['item'])/32);
//        $length = strlen($wearhouse->Items);

//        $length2 = strlen("FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF");
//        var_dump($length);

//        $model = new SingleItemForm();
//        $lists = $model->type_list;
//        echo $this->render("buy_item",['lists'=>$lists,'model'=>$model]);


//        $connect = Yii::$app->db;
//        $sql = "select DBO.varbin2hexstr(Items) from warehouse where AccountID ='zhang004'";
//        $command = $connect->createCommand($sql);
//        $code = $command->queryScalar();
//        $this->StrSplit($code);


    }

    public function StrSplit($str,$length = 32)//按长度切割字符串
    {
        $str_array = array();
        $str_length = strlen($str);
        while ($str_length)
        {
            $str_array[] = substr($str,0,$length);
            $str = substr($str,$length);
            $str_length = strlen($str);
        }
        var_dump($str_array);
    }



}
