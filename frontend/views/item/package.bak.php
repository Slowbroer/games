<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/4
 * Time: 下午3:52
 */


use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

$this->title = $title;


?>

<h3><?php echo $title;?></h3>

<div style="margin: 100px 0;width: 300px;">
    <form action="index.php?r=item/buypackage" method="post" role="form">
        <label class="control-label">
            套装
        </label>
        <div class="form-group required">
            <?php echo Html::dropDownList("id",null,ArrayHelper::map($lists,"Id","Name"),['class'=>'form-control','prompt'=>"请选择套装",'id'=>"package_id"]);?>
        </div>

        <div class="content" style="margin: 20px 10px;font-size: small;color: grey">
            请选择套装进行购买
        </div>
        <input name="_csrf-frontend" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <div style="padding-top: 20px;">
            <button type="submit" class="btn btn-primary">购买</button>
        </div>
    </form>
</div>

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

                    $(".content").html(data.message);
                }
            });
        });
    });

</script>
