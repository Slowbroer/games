<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/6
 * Time: 13:51
 */

namespace frontend\controllers;

use common\models\MEMBINFO;
use frontend\models\RankForm;
use Yii;
use yii\web\Controller;

class RankController extends Controller{

    public function actionCharacterlist(){//英雄排行

//        $mem= MEMBINFO::find()->select("*")->join("LEFT OUTER JOIN",'CharacterCharacter as c',)->where(['ServerCode'=>2])->limit(10)->with('character')->all();
//        $users = $mem->character;



        $model = new RankForm();
        if($model->load(Yii::$app->request->post()))
        {
            $list = $model->c_rank();
            return json_encode($list);
        }
        else
        {
            return null;
        }

    }


    public function actionGuildlist()
    {
        $model = new RankForm();
        if($model->load(Yii::$app->request->post()))
        {
            $list = $model->g_rank();
            return json_encode($list);
        }
        else
        {
            return null;
        }
    }

}