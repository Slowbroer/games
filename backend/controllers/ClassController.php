<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/10
 * Time: 下午2:14
 */

//职业表 class

namespace backend\controllers;


use backend\models\ClassForm;
use backend\models\ClassSet;
use yii\web\Controller;

class ClassController extends Controller
{
    public function actionList()//load the list
    {
        $class = new ClassSet();
        return json_encode($class->getList());
    }

    public function actionUpdate()//add or update a class
    {

        $model = new ClassForm();
        if($model->load(\Yii::$app->request->post()) && $model->update())
        {
            return "success";
        }
        else
        {
            if(!empty($_GET['id'] && is_numeric(intval($_GET['id']))))
            {
                return ClassSet::findOne(['id'=>$_GET['id']]);
            }
            return "failed";
        }
    }







}