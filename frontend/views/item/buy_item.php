<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/12
 * Time: 下午9:42
 */
use frontend\assets\ShopAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use frontend\assets\CommonAsset;

$this->title = "购买装备";
$this->params['breadcrumbs'][] = $this->title;

//ShopAsset::register($this);
CommonAsset::register($this);
?>


<script>
    $(function (e) {
        $("#singleitemform-type").change(function (e) {
            $.ajax({
                url:"index.php?r=item/item_type",
                type:"GET",
                data:"type_id="+$(this).val(),
                success: function (data) {
                    if(data == false)
                    {
                        return false;
                    }
                    data = eval("("+data+")");
                    var html_content = "<option>请选择</option>";
//                    for(var i=0;i<data.length;i++)
//                    {
//                        var data1 = data[i];
//                        for(var key in data1)
//                        {
//                            html_content += "<option value='"+key+"'>"+data1[key]+"</option>"
//                        }
//                    }
                    for (var i in data)//遍历json对象
                    {
                        html_content += "<option value='"+i+"'>"+data[i]+"</option>";
                    }
                    console.log(data);
                    $("#singleitemform-id").html(html_content);
                },
                error:function (data) {
                    alert("获取失败，请重新刷新");
                }
            });
        });
        $("#singleitemform-id").change(function (e) {
            $.ajax({
                url:"index.php?r=item/item_info",
                type:"GET",
                data:"id="+$(this).val(),
                success:function (data) {
                    data = eval("("+data+")");
                    var html_content = "<p>价格："+data.Prise+"</p>";
                    $(".item_info").html(html_content);
                }
            })
        });
    });
</script>

<div class="content">
    <div class="page_news_wrap">
        <div class="tab_type_2 tab_page">
            <h3 class="tab cur"><a href="#">购买装备</a></h3>
            <h3 class="tab"><a href="<?= \yii\helpers\Url::toRoute("item/buypackage")?>">购买套装</a></h3>
            <h3 class="tab"><a href="#">推广奖励</a></h3>
<!--            <div class="cur_pos">-->
<!--                当前位置：<a href="#">奇迹归来</a> &gt; <span class="cur">购买装备</span>-->
<!--            </div>-->
        </div>
        <div class="buy_content buy_content_zb">
            <?php $form = ActiveForm::begin(['id' => 'buy-item']); ?>
            <table border="0" cellpadding="5" cellspacing="0">
                <thead>
                <th>装备类别</th>
                <th>装备内容</th>
                <th>备注</th>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <?php echo $form->field($model,'type')->dropDownList($lists,['style'=>'width:200px;','prompt'=>'请先选择种类'])->label(false);?>
                    </td>
                    <td>
                        <?php echo $form->field($model,'id')->dropDownList([],['prompt'=>'请选择','style'=>'width:400px;'])->label(false);?>
                    </td>
                    <td><span class="item_info" style="">还需充值100积分</span></td>
                </tr>
                </tbody>
            </table>
            <button class="buy" type="submit" >购买装备</button>
<!--            <input class="buy" type="button" value="购买装备"></td>-->
            <?php ActiveForm::end(); ?>
        </div>
        <div class="buy_content buy_content_tz" style="display:none">
            <?php $form = ActiveForm::begin(['id' => 'buy-package']); ?>
            <table border="0" cellpadding="5" cellspacing="0">
                <thead>
                <th>装备类别</th>
                <th>装备内容</th>
                <th>备注</th>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <?php //echo $form->field($model,'type')->dropDownList($lists,['style'=>'width:400px;','prompt'=>'请先选择种类']);?>
                    </td>
                    <td>
                        <?php //echo $form->field($model,'id')->dropDownList([],['prompt'=>'请选择','style'=>'width:400px;']);?>
                    </td>
                    <td><span style="">还需充值100积分</span></td>
                </tr>
                </tbody>
            </table>
            <input class="buy" type="button" value="购买套装"></td>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

