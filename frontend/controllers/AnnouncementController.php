<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/25
 * Time: 下午5:00
 */

namespace frontend\controllers;


use common\models\AnnComment;
use common\models\Announcement;
use common\models\AnnouncementType;
use yii\web\Controller;
use Yii;

class AnnouncementController extends Controller//公共前台功能代码，包括评论和回复的代码
{

//    public function behaviors()
//    {
//        return [
//            [
//                'class' => 'yii\filters\PageCache',
//                'only' => ['all','recent',],
//                'duration' => 600,
//                'variations' => [
//                    \Yii::$app->language,
//                ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT COUNT(*) FROM announcement',
//                ],
//            ],
//        ];
//    }
    public function actionAll()
    {
        $filter["type"] = isset($_GET['type'])? intval($_GET['type']):0;//类别id

//        var_dump($filter);
        $ann = new Announcement();
        $all = $ann->getList($filter);//announcements list

        $ann_type = new AnnouncementType();
        $type_lists = $ann_type->getList();//announcements type list

        array_unshift($type_lists,['id'=>0,'name'=>"综合"]);
//        var_dump($type_lists);
//        die();


        return $this->render("all",['ann'=>$all['list'],'pagination'=>$all['page'],'type_lists'=>$type_lists,'type'=>$filter['type']]);
    }

    public function actionRecent(){
        $ann = new Announcement();
        $filter['type'] = isset($_POST['type'])? $_POST['type']:1;
        $filter['limit'] = isset($_POST['limit'])? $_POST['limit']:10;
        $recent = $ann->recent($filter);
        return json_encode($recent);
    }

    public function actionInfo()
    {
        $id = isset($_REQUEST['id'])? $_REQUEST['id']:0;
        $announcement = Announcement::findOne(['announcement_id'=>$id]);



        $comment = new AnnComment();
        $comment->ann_id = $id;

        $comment_lists = $comment->comment_list();
        if(!$announcement)
        {
            header("index.php");
        }
        else
        {
            return $this->render("info",['model'=>$announcement,'comment'=>$comment,'comment_lists'=>$comment_lists]);
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