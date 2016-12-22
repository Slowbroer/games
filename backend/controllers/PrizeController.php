<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/6
 * Time: 上午10:49
 */

namespace backend\controllers;


use common\models\MuItem;
use common\models\Prize;
use common\models\TzItem;
use yii\web\Controller;
use Yii;

class PrizeController extends Controller
{

    public function actionList(){
        $lists = array();
        $prize = new Prize();
        $lists = $prize->get_as_arrays();

        echo $this->render("list",['lists'=>$lists]);
    }

    public function actionEdit_bak(){
        $id = isset($_GET['id'])? $_GET['id']:0;
        $prize = new Prize();
        if(empty($id))
        {
            $info =$prize;
        }
        else
        {
            $info = $prize->prize_info($id);
        }
        echo $this->render('edit',['model'=>$info]);
    }

    public function actionEdit()
    {
        $id = isset($_GET['id'])? $_GET['id']:0;
        $prize = new Prize();
        $info = $prize->prize_info($id);
        if(empty($info))
        {
            echo $this->render("/site/error",['message'=>"没有找到相应的奖项"]);
        }
        else
        {
            if($prize->load(Yii::$app->request->post()))
            {
                $result = $prize->save();
                if($result)
                {
                    echo $this->render("/site/success",['message'=>"更新成功"]);
                }
                else
                {
                    echo $this->render("/site/error",['message'=>"更新失败"]);
                }
            }
            else
            {
                echo $this->render("edit",['model'=>$info]);
            }
        }
    }

    public function actionAdd(){
        $prize = new Prize();
        if($prize->load(Yii::$app->request->post()))
        {
            $result = $prize->save();
            if($result)
            {
                echo $this->render("/site/success",['message'=>"添加成功"]);
            }
            else
            {
                echo $this->render("/site/error",['message'=>"添加失败"]);
            }
        }
        else
        {
            echo $this->render("edit",['model'=>$prize]);
        }
    }

    public function actionPrize_value(){
        $type = isset($_POST['type'])? $_POST['type']:'';
        if($type == 1)
        {
            $content = "<input class='Prize[prize_value]' type='text'>";
        }
        elseif ($type == 2)
        {
            $content = "<select class='Prize[prize_value]'>
                <option value='0'>左手</option>
                <option value='0'>左手</option>
                <option value='0'>左手</option>
                <option value='0'>左手</option>
                <option value='0'>左手</option>
                <option value='0'>左手</option>
            </select>";
        }
        elseif($type == 3)
        {
            $pakage = new TzItem();
            $lists = $pakage->package_list();
            $content = "<select class='Prize[prize_value]'>";
            foreach ($lists as $key=>$list)
            {
                $content .= "<option value='".$list['Id']."'>".$list['Name']."</option>";
            }
            $content .= "</select>";
        }
        return $content;

    }

}