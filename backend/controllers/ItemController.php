<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/25
 * Time: 上午10:53
 */

namespace backend\controllers;


use backend\models\BuyRecord;
use common\models\MuItem;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;


class ItemController extends Controller
{


    public function actionList()
    {
        //check the user
//        if (!(Yii::$app->user->can('checkItem'))) {
//            echo $this->render("/site/error",['messsage'=>"you have not the right to do this"]);
//            exit;
//        }
        $filter['type'] = isset($_GET['type'])? $_GET['type']:null;

        $item = new MuItem();

        $list = $item->getList($filter);


        echo $this->render("list",['lists'=>$list['lists'],'pagination'=>$list['page']]);
    }


    public function actionEdit()
    {

//        if (!(Yii::$app->user->can('editItem'))) {
//            echo $this->render("/site/error",['messsage'=>"you have not the right to do this"]);
//            exit;
//        }

        $id = isset($_GET['id'])? $_GET['id']:'0';
        $name = "Edit Items";
        if(!empty($id))
        {
            $model=MuItem::findOne(['Id'=>$id]);
            if(isset($model))
            {
                if($model->load(Yii::$app->request->post())&&$model->edit())
                {
                    return $this->render('/site/success',['message'=>'succcess','name'=>$name]);
                }
                else
                {
                    echo $this->render("edit",['model'=>$model,'name'=>$name]);
                }
            }
            else{
                return $this->render('/site/error',['message'=>'there is not this item','name'=>$name]);
            }
        }
        else
        {
            return $this->render('/site/error',['message'=>'para error','name'=>$name]);
        }
    }


    public function actionInfo(){//返回一件装备的详情
        $id = isset($_GET['id'])? $_GET['id']:0;
        if(empty($id))
        {
            return null;
        }
        else
        {
            $info = MuItem::find()->where(['Id'=>$id])->asArray()->one();
            return json_encode($info);
        }
    }



    public function actionShopRecord()//购买记录
    {
        $model = new BuyRecord();
        if($model->load(Yii::$app->request->post())&&$model->validate())
        {
            $list = $model->loadRecord();
            $this->renderPartial();
        }
        else
        {
            return $this->render("BuyRecord",['model'=>$model]);
        }

    }



}