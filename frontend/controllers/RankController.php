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

    public function actionCharacter_list(){//英雄排行



        $model = new RankForm();
        if($model->load(Yii::$app->request->post()) &&  $model->validate())
        {
            $model->c_rank();
        }
        else
        {
            //TODO:这里还要获取到游戏区数据、职业数据和pk数据

            $server = new SetServerList();//游戏区数据
            $server_list = $server->get_list();

            return $this->render("",[
                'model'=>$model,
                'server'=>$server_list,

            ]);
        }
    }

}