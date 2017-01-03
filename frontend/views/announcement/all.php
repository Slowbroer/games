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

?>

<div style="width: 80%;margin: 0 auto;">
    <div>
        <?php foreach ($ann as $key => $value){?>
            <p>
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


