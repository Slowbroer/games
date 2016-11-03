<?php
/**
 * Created by PhpStorm.
 * User: linpeiyu
 * Date: 2016-10-31
 * Time: 11:18
 */

namespace backend\controllers;

use backend\models\TestModel;
use common\models\AnnouncementType;
use Yii;
use yii\web\Controller;
use backend\models\AnnForm;


class AnnouncementController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'ueditor' => [
                'class'=>'yii\cebe'
            ]
        ];
    }



    public function actionEdit()
    {
        //TODO:需要判断是否登录了

        $model = new AnnForm();

        if($model->load(Yii::$app->request->post()) && $model->update())
        {
            return $this->goBack();
        }
        else
        {
            $type = new AnnouncementType();
            $type_list = $type->getList();

            return $this->render('edit',[
                'model'=>$model,
                'type_list'=>$type_list,
            ]);
        }
    }

}