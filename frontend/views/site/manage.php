<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/16
 * Time: 上午10:37
 */
use frontend\assets\ManageAsset;

//ManageAsset::register($this);
$this->title = "帐号管理";
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="content">
    <div class="page_news_wrap">
        <div class="tab_type_2 tab_page tab_page_2 ">
            <span class="com_arrow icon-play_arrow"></span>
            <h3 class="tab cur"><a href="#">账号管理</a></h3>
<!--            <div class="cur_pos">-->
<!--                当前位置：<a href="#">奇迹归来</a> &gt; <span class="cur">账号管理</span>-->
<!--            </div>-->
        </div>
        <div class="tab_content">
            <table>
                <thead>
                <th>游戏分区</th>
                <th>帐号</th>
                <th>币</th>
                <th>积分</th>
                </thead>
                <tbody>
                <tr>
                    <td>新版（洛克之羽）一区</td>
                    <td>青青</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>