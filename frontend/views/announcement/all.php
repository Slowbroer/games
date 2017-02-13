<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/28
 * Time: 下午3:45
 */
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = "公告";
$this->params['breadcrumbs'][] = $this->title;

?>

<div style="width: 100%;margin: 0px 5px;height: 1395px;padding-top: 20px;">
    <div>
        <?php foreach ($ann as $key => $value){?>
            <p style="margin: 10px 50px;">
                <a href="<?php echo Url::toRoute(['announcement/info','id'=>$value['announcement_id']]);?>"><?= "(".$value['type_name'].")".$value['name'];?></a>

                <span style="float: right;"><?= date("Y-m-d H:i",$value['add_time']);?></span>
            </p>
        <?php }?>
    </div>


    <div style="text-align: center;">
        <?php
            echo LinkPager::widget([
            'pagination' => $pagination,
            ]);
        ?>
    </div>

</div>


