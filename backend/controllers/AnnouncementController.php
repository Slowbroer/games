<?php
/**
 * Created by PhpStorm.
 * User: linpeiyu
 * Date: 2016-10-31
 * Time: 11:18
 * 后台公告控制器，主要是用于编辑公告和发布公告
 */

namespace backend\controllers;

use backend\models\AnntypeForm;
use backend\models\TestModel;
use common\models\Announcement;
use common\models\AnnouncementType;
use Yii;
use yii\web\Controller;
use backend\models\AnnForm;


class AnnouncementController extends Controller//公告控制器
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }



    public function actionEdit()
    {
        //需要判断是否登录了
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new AnnForm();

        if($model->load(Yii::$app->request->post()) && $model->update())
        {
            return $this->goBack();
        }
        else
        {
            $id = isset($_GET['id'])? $_GET['id']:null;
            if($id)
            {
                $ann = Announcement::findOne(['announcement_id'=>$id]);
                $model['id'] = $ann['announcement_id'];
                $model['title'] = $ann['name'];
                $model['type_id'] = $ann['type'];
                $model['content'] = $ann['announcement_content'];
//                var_dump($model['content']);
            }
            $type = new AnnouncementType();
            $type_list = $type->getList();

            return $this->render('edit',[
                'model'=>$model,
                'type_list'=>$type_list,
            ]);
        }
    }

    public function actionList()
    {
        $filter['type'] = isset($_GET['type'])? $_GET['type']:'';
        $ann = new Announcement();
        $list = $ann->getList($filter);

        var_dump($list);
//        $content = $this->renderPartial('list',['lists'=>$list]);
        $content = $this->render('list',['lists'=>$list]);

        return $content;
    }

    public function actionDel()
    {
        $id = isset($_GET['id'])? $_GET['id']:'';

    }

    public function actionUpdatetype(){
        $model = new AnntypeForm();
        if($model->load(Yii::$app->request->post()) && $model->update())
        {
            return true;
        }
        else
        {
            if(!empty($_GET['id'] && is_numeric(intval($_GET['id']))))
            {
                return AnnouncementType::findOne(['id'=>$_GET['id']]);
            }

            return false;
        }
    }


}