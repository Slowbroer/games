<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/8
 * Time: 下午9:07
 */

use yii\helpers\Url;

?>



<div class="content">
    <div class="slider_news clearfix">
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
            <div class="tab_type_1">
                <h3 class="tab cur"><a href="javascript:;">综合</a></h3>
                <h3 class="tab"><a href="javascript:;">公告</a></h3>
                <h3 class="tab"><a href="javascript:;">活动</a></h3>
                <h3 class="tab"><a href="javascript:;">新闻</a></h3>
                <a href="http://mu.niu.xunlei.com/zonghe/1.shtml" target="_blank" class="hd_more">more+</a>
            </div>
            <div class="news_tab_con">
                <div class="cont_item">
                    <div class="newsListBox">
                        <ul class="news_list" style="display: block;">
                            <li>
                                <span class="com_arrow icon-play_arrow"></span>
                                <span class="cat">公告</span>
                                <span class="txt"><a href="#" target="_blank" title="通知" class="fcy fb">通知通知通知通知通知通知通知通知通知通知</a></span>
                                <span class="date">11-18</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="game_link clear mb">
        <ul class="clearfix">
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src="http://i2.webgame.kanimg.com/20150126/1422237656845.jpg" alt="" width="180" height="118">
                    <span class="btn">go></span>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src="http://i2.webgame.kanimg.com/20150126/1422237656845.jpg" alt="" width="180" height="118">
                    <span class="btn">go></span>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src="http://i2.webgame.kanimg.com/20150126/1422237656845.jpg" alt="" width="180" height="118">
                    <span class="btn">go></span>
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="niuxReportLink" rdata="g3_indexad:item1">
                    <img src="http://i2.webgame.kanimg.com/20150126/1422237656845.jpg" alt="" width="180" height="118">
                    <span class="btn">go></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="video_partner bg_type_2 mb">
        <div class="tab_type_2">
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

            </div>
        </div>
    </div>
    <div class="gameimg bg_type_2">
        <div class="tab_type_2">
            <h3 class="tab"><a>游戏原画</a></h3>
            <h3 class="tab cur"><a>游戏截图</a></h3>
        </div>
        <div class="tab_con">
            <div class="img_container">
                <img src="http://i1.webgame.kanimg.com/20150121/1421810419823.jpg" _bsrc="http://i0.webgame.kanimg.com/20150121/1421810414531.jpg" idx="0" alt="" width="168" height="110">
            </div>
        </div>
    </div>
</div>
