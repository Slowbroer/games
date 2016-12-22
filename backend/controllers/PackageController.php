<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/26
 * Time: 下午2:48
 */

namespace backend\controllers;


use common\models\MuItem;
use common\models\TzItem;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class PackageController extends Controller
{

    public $item_types = array(
        'zuoshou'=>'左手',
        'youshou'=>'右手',
        'tou'=>'头盔',
        'kai'=>'铠甲',
        'shou'=>'守护',
        'tui'=>'腿',
        'xie'=>'鞋子',
        'xianglian'=>'项链',
        'zuojiezhi'=>'左戒指',
        'youjiezhi'=>'右戒指',

    );

    public function actionList(){
        $package = new TzItem();
        $lists = $package->package_list();
        echo $this->render("list",['lists'=>$lists]);
    }

    public function actionEdit(){
        $id = isset($_GET['id'])? $_GET['id']:0;
        $model = TzItem::findOne(['Id'=>$id]);
        if(!isset($model))
        {
            echo $this->render("/site/error",['message'=>'找不到相应的套装','name'=>'编辑套装']);
        }
        else
        {
            if($model->load(Yii::$app->request->post())&&$model->validate())
            {
                $result = $model->package_update();//update the package
                if($result === true)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            $items = $model->getItem();
            echo $this->render("edit",['model'=>$model,'items'=>$items,]);
        }
    }

    public function actionInfo()//查看详情接口，还没完成
    {
        $id = isset($_GET['id'])? $_GET['id']:0;
        $package = TzItem::findOne(['Id'=>$id]);
        if(isset($package)){
            return json_encode($package->attributes);
        }
        else
        {
            return null;
        }
    }


    public function actionSaveitem(){//保存装备 ajax接口

        $id = isset($_POST['id'])? $_POST['id']:0;
        $package = TzItem::findOne(["Id"=>$id]);
        if(!isset($package))
        {
            return false;
        }
        $item_array = isset($_POST['MuItem'])? $_POST['MuItem']:array();
        if($item_array['Id']>0) {
            $item = MuItem::findOne(['Id' => $item_array['Id']]);
            if (isset($item) && $item->load(Yii::$app->request->post()) && isset($_POST['type'])) {
                $code = $item->createCode();
//                var_dump($item);
                $package->setAttribute($_POST['type'], $code);
                $result = $package->save();
                if($result)
                {
                    return "success";
                }
            }
        }
        else
        {
            $package->setAttribute($_POST['type'], null);
            $result = $package->save();
            if($result)
            {
                return "success";
            }
        }
        return false;
    }


}