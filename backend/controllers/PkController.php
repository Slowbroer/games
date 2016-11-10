<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/10
 * Time: 下午3:14
 */

namespace backend\controllers;


use backend\models\PkForm;
use backend\models\PKstatus;
use yii\web\Controller;

class PkController extends Controller
{

    public function actionList()//load the list
    {
        $pk = new PKstatus();
        return json_encode($pk->getList());
    }

    public function actionUpdate(){//add or upadte a pk_status

        $model = new PkForm();
        if($model->load(\Yii::$app->request->post()) && $model->update())
        {
            return "success";
        }
        else
        {
            return "failed";
        }
    }


}