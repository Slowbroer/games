<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/15
 * Time: 下午10:34
 */
use frontend\assets\ShopAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

$this->title = "购买装备";
$this->params['breadcrumbs'][] = $this->title;

ShopAsset::register($this);
?>

<script type="text/javascript">
    $(function (e) {
//        var csrfToken = $('meta[name="csrf-token"]').attr("content");
//        console.log(csrfToken);
        $("#package_id").change(function (e) {
            $.ajax({
                url:"index.php?r=item/packageinfo",
                type:"POST",
                data:"id="+$(this).val(),
                success:function (data) {
                    data = eval("("+data+")");

                    $(".item_info").html(data.message);
                }
            });
        });
    });

</script>

<div class="content">
    <div class="page_news_wrap">
        <div class="tab_type_2 tab_page">
            <h3 class="tab"><a href="#">购买装备</a></h3>
            <h3 class="tab cur"><a href="#">购买套装</a></h3>
            <h3 class="tab"><a href="#">推广奖励</a></h3>
        </div>
        <div class="buy_content buy_content_tz" style="">
            <?php $form = ActiveForm::begin(['id' => 'buy-package']); ?>
            <table border="0" cellpadding="5" cellspacing="0">
                <thead>
<!--                <th>装备类别</th>-->
                <th>装备内容</th>
                <th>备注</th>
                </thead>
                <tbody>
                <tr>
<!--                    <td>-->
<!--                        <select name="type">-->
<!--                            <option>左手</option>-->
<!--                            <option>右手</option>-->
<!--                        </select>-->
<!--                    </td>-->
                    <td>
                        <?php echo Html::dropDownList("id",null,ArrayHelper::map($lists,"Id","Name"),['class'=>'form-control','prompt'=>"请选择套装",'id'=>"package_id"]);?>
                    </td>
                    <td><span class="item_info" style="">还需充值100积分</span></td>
                </tr>
                </tbody>
            </table>
            <button class="buy" type="submit" >购买套装</button>
<!--            <input class="buy" type="button" value="购买套装"></td>-->
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
