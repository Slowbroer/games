<?php


use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

    <div class="left">
        <div class="left_one" id="lofinDiv" >
            <div class="l_one">
                <div class="dengluhou" style="display:none">
                    <h3>
                        登录
                        <a href="LoginSession.php?out=out" class="tui">退出登录</a>
                    </h3>
                    <p>用户ID:<span></span></p>
                    <a href="#" class="game">开始游戏</a>
                    <div class="dengluhou_foot">
                        <a href="register.php" class="manage" >账号管理</a>
                        <span>|</span>
                        <a href="download.php" class="buy">充值中心</a>
                    </div>
                </div>
                <div class="dengluqian">
                    <form onsubmit="javascript:return checkLogin();" id="form2" name="form2" method="post" action="main.php">
                        <h3>登录</h3>
                        <div class="errorplace"></div>
                        <div class="denglu">
                            <button id="Login" name="Login" class="submit" type="submit" >登錄</button>
                            <div class="input">
                                <input class="in_text" type="text" id="username" name="user_name" placeholder="用戶名">
                                <input type="password" class="in_text2" id="password" name="password" placeholder="密碼">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                    </form>
                    <div class="re">
                        <a href="reg.php" class="register" >游戏註冊</a>
                        <span>|</span>
                        <a href="getPw.php" class="download">找回密码</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="left_two">
            <div class="share">
            </div>
        </div>
        <!--積分榜-->
        <div class="left_four">
            <div class="four_ban"><a href="#">更多</a> 等級排行榜</div>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>名字</th>
                    <th>等级</th>
                    <th>职业</th>
                    <th>PK状态</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ranks as $key=>$rank){ ?>
                    <tr>
                        <td><?= Html::encode($key+1);?></td>
                        <td><?= Html::encode($rank['Name']);?></td>
                        <td><?= Html::encode($rank['PkLevel']);?></td>
                        <td><?= Html::encode($rank['ZY_name']);?></td>
                        <td><?= Html::encode($rank['PK_name']);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!--游戲玩法-->
        <div class="left_three">
            <div class="three_ban"><a href="#">更多</a> 游戲玩法</div>
            <ul id="play" style="list-style: none;padding-left: 0px;"></ul>
        </div>
        <!--玩家交流群-->
        <div class="left_five" id="qq">
            <div class="five_ban"><a href="#">更多</a> 玩家交流群</div>
        </div>
    </div>
    <div class="right_in">
        <div class="right_one">
            <!--服務器情況-->
            <div class="one_right">
                <div class="service">
                    <h3 id="ser">服務器情況</h3>
                    <div class="ser_dec">
                        <p class="name">
                            <span class=" icon icon1"></span>
                            <span>游戲名稱：</span>
                            <span></span>
                        </p>
                        <p class="version">
                            <span class=" icon icon2"></span>
                            <span>游戲版本：</span>
                            <span></span>
                        </p>
                        <p class="index">
                            <span class=" icon icon3"></span>
                            <span>電信主頁：</span>
                            <span></span>
                        </p>
                        <p class="version">
                            <span class=" icon icon4"></span>
                            <span>客服ＱＱ：</span>
                            <span></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="one_left">
                <!--輪播圖-->
                <object type="application/x-shockwave-flash" data="pic/dg_maincha.swf" width="466" height="186" wmode="transparent" quality="high" bgcolor="#FFFFFF" allowscriptaccess="always" allowfullscreen="false">
                </object>
            </div>
        </div>
        <!--移動文字-->
        <div class="right_five">
            <marquee direction="left" behavior=scroll  scrollamount=7 scrolldelay=1 onmouseover='this.stop()' onmouseout='this.start()' valign="middle" class="marquee">
                <a href="reg.php">【亂世首區】今日17點開放體驗!19點開放轉生！趕快注冊吧~~！</a>
            </marquee>
        </div>
        <div class="right_two">
            <div class="two_ban">
                <a href="#">更多</a>
                <div class="tit">
                    公告
                </div>
            </div>
            <div class="rtwo_foot">
                <div class="r_right">
                    <ul id="news">
                    </ul>
                </div>
                <div class="r_left">
                    <div class="tupp">
                        <a href="#"><img src="images/bottom-video.gif" style="width:100%"/> </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="right_three" style="height:400px">
            <div class="three_ban">
                <a href="#">更多</a>
                <div class="tit">
                    游戲介紹
                </div>
            </div>
            <div class="rthree_foot">
                <div class="rr_right">
                    <ul id="GMintr">

                    </ul>
                </div>
            </div>
        </div>
        <div class="right_four">
            <div class="four_ban">
                <a href="#">更多</a>
                <div class="tit">
                    截圖
                </div>
            </div>
            <div class="four_pic" id="images">

            </div>
        </div>
    </div>
