<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/25
 * Time: 下午5:00
 */

namespace frontend\controllers;


use common\models\Announcement;
use yii\web\Controller;
use Yii;

class AnnouncementController extends Controller//公共前台功能代码，包括评论和回复的代码
{

    public function actionInfo()
    {
        $id = isset($_REQUEST['id'])? $_REQUEST['id']:0;
        $announcement = Announcement::findOne(['announcement_id'=>$id]);
        if(!$announcement)
        {
            header("index.php");
        }
        else
        {
            return $this->render("info",['model'=>$announcement]);
        }
    }

    public function actionComment()
    {
        $id = isset($_REQUEST['id'])? $_REQUEST['id']:0;//公告id
        $content = isset($_REQUEST['content'])? $_REQUEST['content']:'';
        $announcement = Announcement::findOne(['announcement_id'=>$id]);
        if(!$announcement)
        {
            return $this->render("/site/error",['message'=>'未找到相应的公告']);
        }
        else
        {
            if(empty($content))
            {
                return $this->render("/site/error",['message'=>'请填写相应的评论']);
            }
            else
            {
                $memb_id = Yii::$app->user->identity->getMenb();
                $add_time = time();

            }
        }
    }
}