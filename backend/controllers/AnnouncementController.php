<?php
/**
 * Created by PhpStorm.
 * User: linpeiyu
 * Date: 2016-10-31
 * Time: 11:18
 */

namespace backend\controllers;

use Yii;
use backend\models\AnnouncenmentForm;
use yii\web\Controller;


class AnnouncementController extends Controller{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionAnnouncement()
    {


    }

    public function actionEdit()
    {
        //TODO:需要判断是否登录了

        $model = new AnnouncenmentForm();
        if($model->load(Yii::$app->request->post()) && $model->update())
        {
            return $this->goBack();
        }
        else
        {
            return $this->render('edit',[
                'model'=>$model,
            ]);
        }
    }

}