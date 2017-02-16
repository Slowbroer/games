<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/16
 * Time: 下午8:53
 */
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

\frontend\assets\CommonAsset::register($this);


$this->title = '公告列表';
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="content">
    <div class="page_news_wrap">
        <div class="tab_type_2 tab_page">
            <?php foreach ($type_lists as $key => $type_list){?>
                <?php if($type == $type_list['id']){?>
                    <h3 class="tab cur"><a href="<?= Url::toRoute(['announcement/all','type'=>$type_list['id']]);?>"><?= Html::encode($type_list['name']);?></a></h3>
                <?php }else{?>
                    <h3 class="tab"><a href="<?= Url::toRoute(['announcement/all','type'=>$type_list['id']]);?>"><?= Html::encode($type_list['name']);?></a></h3>
                <?php }?>
            <?php }?>
        </div>
        <div class="page_news_list_wrap">
            <ul class="page_news_list">
                <?php foreach ($ann as $key => $value){?>
                <li>
                    <span class="com_arrow icon-play_arrow"></span>
                    <div class="news_con">
                        <a href="<?= Url::toRoute(['announcement/info','id'=>$value['announcement_id']]);?>" title="<?= Html::encode($value['name']);?>" target="_blank" class="fcy fb"><?= "[".$value['type_name']."]".$value['name'];?></a>
                    </div>
                    <span class="date"><?= date("Y-m-d",$value['add_time']);?></span>
                </li>
                <?php }?>
            </ul>
        </div>
        <div style="text-align: center;">
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
            ]);
            ?>
        </div>
<!--        <div class="page">-->
<!--            <p>-->
<!--                <a class="txtlink dis">&lt;&lt;上一页</a>-->
<!--                <a class="cur">1</a><a href="#">2</a>-->
<!--                <a href="#">3</a>-->
<!--                <a href="#">4</a>-->
<!--                <a href="#" title="" class="txtlink">下一页&gt;&gt;</a>-->
<!--            </p>-->
<!--        </div>-->
    </div>
</div>
