<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/12
 * Time: 下午5:12
 */

namespace backend\controllers;


use common\models\Introduce;
use yii\filters\PageCache;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;

class IntroduceController extends Controller
{
    public function behaviors()
    {
        return [
//            'cache'=>[
//                'class' => 'yii\filters\PageCache',
//                'only' => ['index'],
//                'duration' => 1,
//                'variations' => [
//                    \Yii::$app->language,
//                ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT count(*) FROM introduce where is_able = 1 ',
//                    //这里表示如果文章总数发生变化则缓存会失效
//                ],
//            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'all', 'info','delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'all', 'info','delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $filter['pageSize'] = isset($_POST['pageSize'])? $_POST['pageSize']:20;

        $model = new Introduce();
        $model->is_show =1;
        $lists = $model->all($filter);
//        var_dump($lists);
        return $this->render("index",['model'=>$model,'lists'=>$lists['list'],'page'=>$lists['page']]);

    }
    public function actionAll(){
        $filter['pageSize'] = isset($_POST['pageSize'])? $_POST['pageSize']:20;

        $introduce = new Introduce();
        $lists = $introduce->all($filter);

        return $this->renderPartial("list",['lists'=>$lists['list'],'page'=>$lists['page']]);
    }


//    public function actionInfo()
//    {
//        $id = Yii::$app->request->get('id');
//
//        $info = array();
//        if(!empty($id))
//        {
//            $introduce = Introduce::findOne(['id'=>$id]);
//            if (isset($introduce))
//            {
//                if($introduce->load(Yii::$app->request->post()))//update
//                {
//                    $info['code'] = $introduce->save()? 1:0;
//
//                }
//                else//info
//                {
//                    $info = $introduce->attributes;
//                }
//            }
//        }
//        else
//        {
//            $introduce = new Introduce();
//            if($introduce->load(Yii::$app->request->post()))
//            {
//                $info['code'] = $introduce->save()? 1:0;
//            }
//        }
//        return json_encode($info);
//    }

    public function actionInfo()
    {
        $id = Yii::$app->request->get('id');
        if(empty($id))
        {
            $info['code'] = 0;
            $info['message'] = "参数错误";
        }
        else
        {
            $introduce = Introduce::findOne(['id'=>$id]);
            if(isset($introduce))
            {
                $info = $introduce->attributes;
                $info['code'] = 1;
            }
            else
            {
                $info['code'] = 0;
                $info['message'] = "没有找到相应的介绍";
            }
        }
        return json_encode($info);
    }

    public function actionUpdate(){
        $id = Yii::$app->request->post('introduce_id');
        if(empty($id))
        {
            $introduce = new Introduce();
            $introduce->add_time = time();
            $introduce->update_time = time();
            $introduce->brief = "简介";
            if($introduce->load(Yii::$app->request->post())&&$introduce->validate())
            {
                return $introduce->save()? "添加成功":"添加失败";
            }
            else
            {
                return "添加失败，可能是因为设置的值有误，请重新设置游戏介绍的值";
            }
        }
        else
        {
            $introduce = Introduce::findOne(['id'=>$id]);
            if(isset($introduce)&&$introduce->load(Yii::$app->request->post()))
            {
                $introduce->update_time = time();
                return $introduce->save()? "更新成功":"更新失败";
            }
            else
            {
                return "没有找到该游戏介绍或者设置的值有误";
            }
        }
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get("id");
        $introduce = Introduce::findOne(['id'=>$id]);
        if(isset($introduce))
        {
            $introduce->is_able = 0;
            return $introduce->save()? true:false;
        }
        else
        {
            return false;
        }
    }




}