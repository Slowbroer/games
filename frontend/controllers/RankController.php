<?php
/**
 * Created by PhpStorm.
 * User: linhaha
 * Date: 2016/11/6
 * Time: 13:51
 */

namespace frontend\controllers;

use backend\models\ClassSet;
use common\models\MEMBINFO;
use frontend\models\RankForm;
use Yii;
use yii\web\Controller;
use common\models\SetServerList;

class RankController extends Controller{//排行控制器

    public $enableCsrfValidation =false;

    public function actionCharacterlist(){//英雄排行

        $model = new RankForm();
        if($model->load(Yii::$app->request->post())&&$model->validate())
        {
//            var_dump($model->career);
            $list = $model->c_rank();
            if(empty($list))
            {
                return json_encode(array('code'=>0,'message'=>'没有相应排行'));
            }
            else
            {
//                $content = $this->renderPartial("list",['lists'=>$list]);
                return json_encode($list);
            }
        }
        else
        {
            return json_encode(array('code'=>0,'message'=>'查询条件不满足'));
        }
    }


    public function actionGuildlist()
    {
        $model = new RankForm();
        if($model->load(Yii::$app->request->post()))
        {
            $list = $model->g_rank();
            if(empty($list))
            {
                return json_encode(array('code'=>0,'message'=>'没有相应排行'));
            }
            else
            {
//                $content = $this->renderPartial("guild_list",['lists'=>$list]);
                return json_encode($list);
            }
//            return json_encode($list);
        }
        else
        {
            return json_encode(array('code'=>0,'message'=>'查询条件不满足'));
        }
    }

    public function actionDefault(){
        $model = new RankForm();
        $server = new SetServerList();
        $server_list = $server->get_list();

        $class = new ClassSet();
        $class_lists = $class->get_list();

        echo $this->render("default",['model'=>$model,'lists'=>$server_list,'name'=>'英雄排行','class_lists'=>$class_lists]);
    }

    public function actionGuilddefault(){
        $model = new RankForm();
        $server = new SetServerList();
        $server_list = $server->get_list();

        echo $this->render("guild_default",['model'=>$model,'lists'=>$server_list,'name'=>'战盟排行']);
    }


    public function actionLoadcareer()
    {
        $career = array(0=>'魔法师',1=>'魔导师',2=>'神导师',3=>'神导师',16=>'剑士',17=>'骑士',18=>'神骑士',19=>'神骑士',32=>'弓箭手',33=>'圣射手',34=>'神射手',35=>'神射手',48=>'魔剑士',49=>'剑圣',50=>'剑圣',51=>'剑圣',64=>'圣导师',65=>'祭师',66=>'祭师',67=>'祭师',80=>'召唤术师',81=>'召唤导师',82=>'召唤巫师',83=>'召唤巫师',96=>'角斗士',97=>'角斗师',98=>'角斗师',99=>'角斗师');

        foreach ($career as $key => $value)
        {
            $class = new ClassSet();
            $class->class_id = $key;
            $class->class_name = $value;
            $class->save();
        }

    }


    public function actionLevelrank()
    {
        $model = new RankForm();
        $list = $model->g_rank();
        if(empty($list))
        {
            return json_encode(array('code'=>0,'message'=>'没有相应排行'));
        }
        else
        {
//                $content = $this->renderPartial("list",['lists'=>$list]);
            return json_encode($list);
        }

    }



}