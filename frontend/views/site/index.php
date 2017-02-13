<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/8
 * Time: 下午9:07
 */

use yii\helpers\Url;
use yii\bootstrap\Html;
use frontend\assets\HomeAsset;


//HomeAsset::register($this);
?>



<div class="content">
    <div class="slider_news clearfix mb">
        <div class="content_slider">
            <!--輪播圖 begin-->
            <div class="swiper-container1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src='<?= Url::to("@web/images/home_page/title2.jpg");?>'>
                    </div>
                    <div class="swiper-slide"><img src='<?= Url::to("@web/images/home_page/title2.jpg");?>'></div>
                    <div class="swiper-slide"><img src='<?= Url::to("@web/images/home_page/title2.jpg");?>'></div>
                </div>
                <!-- 如果需要分页器 -->
                <div class="swiper-pagination"></div>
            </div>
            <!-- 轮播图 end -->
        </div>
        <div class="news bg_type_1">
            <div class="tab_type tab_type_1">
                <?php
                foreach ($ann_types as $key=>$ann_type){
                    if($key == 0)
                    {
                        echo "<h3 class=\"tab cur\"><a href='".Url::toRoute("site/index")."'>".$ann_type['name']."</a></h3>";
                    }
                    else
                    {
                        echo "<h3 class=\"tab\"><a href='".Url::toRoute("site/index")."'>".$ann_type['name']."</a></h3>";
                    }
                }
                ?>
                <a href="index.php?r=announcement/all" target="_blank" class="hd_more">more+</a>
            </div>
            <div class="news_tab_con tab_con">
                <?php foreach ($ann_lists as $key=>$ann_list){?>
                    <div class="cont_item" <?php if($key!=0)echo "style='display: none;'";?> >
                        <div class="newsListBox">
                            <ul class="news_list">
                                <?php foreach ($ann_list as $v=>$ann){?>
                                <li>
                                    <span class="com_arrow icon-play_arrow"></span>
                                    <span class="cat"><?= $ann['type_name'];?></span>
                                    <span class="txt"><a href="<?= Url::toRoute(['announcement/info','id'=>$ann['announcement_id']])?>" target="_blank"  class="fcy fb"><?= $ann['name'];?></a></span>
                                    <span class="date"><?= date("Y-m",$ann['add_time']);?></span>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="game_link clear mb">
        <ul class="clearfix">
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src='<?= Url::to("@web/images/home_page/no21.jpg");?>' alt="" width="210" height="154">
                    <span class="btn">go></span>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src='<?= Url::to("@web/images/home_page/no31.jpg");?>' alt="" width="210" height="154">
                    <span class="btn">go></span>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src='<?= Url::to("@web/images/home_page/no41.jpg");?>' alt="" width="210" height="154">
                    <span class="btn">go></span>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src='<?= Url::to("@web/images/home_page/no51.jpg");?>' alt="" width="210" height="154">
                    <span class="btn">go></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="video_partner bg_type_2 mb">
        <div class="tab_type tab_type_2">
            <h3 class="tab"><a>游戏视频</a></h3>
            <h3 class="tab cur"><a>伙伴展示</a></h3>
        </div>
        <div class="tab_con">
            <div class="cont_item clearfix" style="display:none">
                <div class="video" id="video-box">
                    <a href="javascript:;" id="to-play" data-videourl="http://preloaddown.boxsvr.niu.xunlei.com/webgame/mu_video.flv "><img src="http://i1.webgame.kanimg.com/20150122/1421920823339.jpg" width="338" height="240" alt="">
                        <span class="btn_play png"></span>
                    </a>
                </div>
                <div class="video_intro">
                    <div class="hd">
                        <span class="com_arrow icon-play_arrow"></span>
                        <h4>奇迹归来游戏介绍</h4>
                    </div>
                    <div class="bd">
                        <p>介绍介绍介绍介绍介绍介绍介绍介绍</p>
                        <div class="btn_v_start"><a href="#" target="_blank" class="btn_v_start niuxReportLink" rdata="g3_indexvedio:entergame">进入游戏&gt;&gt;</a></div>
                    </div>
                </div>
            </div>
            <div class="cont_item">
                <!--輪播圖 begin-->
                <div class="cont_slider">
                    <div class="swiper-container2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="<?= Url::to("@web/images/home_page/title2.jpg");?>">
                            </div>
                            <div class="swiper-slide">

                                <div class="video" id="video-box">
                                    <a href="javascript:;" id="to-play" data-videourl="http://preloaddown.boxsvr.niu.xunlei.com/webgame/mu_video.flv "><img src="http://i1.webgame.kanimg.com/20150122/1421920823339.jpg" width="338" height="240" alt="">
                                        <span class="btn_play png"></span>
                                    </a>
                                </div>
                                <div class="video_intro">
                                    <div class="hd">
                                        <span class="com_arrow icon-play_arrow"></span>
                                        <h4>奇迹归来游戏介绍</h4>
                                    </div>
                                    <div class="bd">
                                        <p>介绍介绍介绍介绍介绍介绍介绍介绍</p>
                                        <div class="btn_v_start"><a href="#" target="_blank" class="btn_v_start niuxReportLink" rdata="g3_indexvedio:entergame">进入游戏&gt;&gt;</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide"><img src="<?= Url::to("@web/images/home_page/title2.jpg");?>"></div>
                        </div>
                        <!-- 如果需要分页器 -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <!-- 轮播图 end -->
            </div>
        </div>
    </div>
    <div class="gamedata bg_type_2 mb">
        <div class="bg_type_2">
            <div class="cont_hd">
                <span class="icon-addressbook"></span>
                <h6>游戏资料</h6>
            </div>
            <div class="datalink">
                <div class="data_item">
                    <div class="dataListBox">
                        <ul class="data_list">
                            <li>
                                <span class="com_arrow icon-play_arrow"></span>
                                <span class="cat">公告</span>
                                <span class="txt"><a href="#" target="_blank" title="通知" class="fcy fb">通知通知通知通知通知通知通知通知通知通知通知通知通知通知通知通知通知通知通知</a></span>
                                <span class="date">11-18</span>
                            </li>
                            <li>
                                <span class="com_arrow icon-play_arrow"></span>
                                <span class="cat">活动</span>
                                <span class="txt"><a href="#" target="_blank" title="活动" class="fcy fb">活动活动活动活动活动活动活动活动</a></span>
                                <span class="date">11-18</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="gameimg bg_type_2">
            <div class="tab_type tab_type_2">
                <h3 class="tab cur"><a>游戏原画</a></h3>
                <h3 class="tab "><a>游戏截图</a></h3>
            </div>
            <div class="tab_con">
                <div class="cont_item" style="display: block;">
                    <div class="img_container">
                        <img src="http://i1.webgame.kanimg.com/20150121/1421810419823.jpg" _bsrc="http://i0.webgame.kanimg.com/20150121/1421810414531.jpg" idx="0" alt="" width="168" height="110">
                    </div>
                </div>
                <div class="cont_item" style="display: none;">
                    <div class="img_container">
                        <img src="img/no21.jpg" _bsrc="http://i0.webgame.kanimg.com/20150121/1421810414531.jpg" idx="0" alt="" width="168" height="110">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
