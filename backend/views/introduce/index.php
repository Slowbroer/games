<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/13
 * Time: 上午12:29
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;


?>

<script>
    function editIntroduce(id) {
        $.ajax({
            url:"index.php?r=introduce/info&id="+id,
            success:function (data) {
                data = eval("("+data+")");
                if(data.code == 1)
                {
                    $("#introduce-title").val(data.title);
                    $("#introduce-content").val(data.content);
                    $("#introduce_id").val(data.id);
                    $(":radio[name='Introduce[is_show]'][value='"+data.is_show+"']").attr("checked","checked");
                    $("#myModal").modal("show");
                }
                else
                {
                    alert(data.message);
                }
            },
            error:function (data) {
                alert("读取失败，请刷新页面")
            }

        })
    }
    function addIntroduce() {

        $("#myModal").modal("show");
    }
    function deleteIntroduce(id) {
        $.ajax({
            url:"index.php?r=introduce/delete&id="+id,
            success:function (data) {
                if(data)
                {
                    alert("删除成功");
                    location.href="index.php?r=introduce/index";
                }
                else
                {
                    alert("删除失败");
                }
            },
            error:function (data) {
                alert("删除失败");
            }
        })
    }
    $(function () {
        $("#introduce-edit").on("beforeSubmit",function () {
            var form = $(this);
            form.data('yiiActiveForm').validated = true;
            $.ajax({
                url:form.attr("action"),
                type:form.attr("method"),
                data:form.serialize(),
                success:function (data) {
                    alert(data);
                    $("#myModal").modal("hide");
                    location.href="index.php?r=introduce/index";
//                    data = eval("("+data+")");
//                    if(data.code == 1)
//                    {
//                        alert("succcess");
//                        loadIntroduces();
//                        $("#myModal").modal("hide");
//                    }
//                    else
//                    {
//                        alert("failed");
//                        $("#myModal").modal("hide");
//                    }
                },
                error:function (data) {
                    alert("error");
                }
            });
            return false;
        });
    });
//    function loadIntroduces() {
//        $.ajax({
//            url:"index.php?r=introduce/all",
//            success:function (data) {
//                $("#introduceList").html(data);
//            },
//            error:function (data) {
//                $("#introduceList").html("加载出错，请刷新");
//            }
//        });
//    }
</script>

<div>
    <div id="introduceList">
        <div class="panel panel-success" style="margin: 20px auto;width: 80%">
            <?php foreach($lists as $list){ ?>
                <div class="panel-heading">
                    <a href="#" onclick="editIntroduce(<?php echo $list['id'];?>)"><?= $list['title']."-".$list['content']; ?></a>

                    <a style="float: right;" href="#" onclick="deleteIntroduce(<?= $list['id'];?>)">删除</a>

                    <span style="float: right;margin-right: 10px;"><?= date("Y-m-d H:i",$list['update_time']);?></span>

                </div>
            <?php } ?>
        </div>

        <div style="text-align: center">
            <?php
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $page,
            ]);
            ?>
        </div>
    </div>
    <button onclick="addIntroduce()" class="btn btn-default">
        添加
    </button>

</div>

<style>
    .radio {
        display: inline-block;
    }
</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">游戏介绍</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'introduce-edit','action'=>Url::toRoute("introduce/update")]); ?>

                <?php echo $form->field($model,"title");?>

                <?php echo $form->field($model,"content")->textarea();?>

                <?php echo $form->field($model,"is_show")->radioList(['1'=>"显示",'0'=>"不显示"]);?>

                <input type="hidden" name="introduce_id" value="" id="introduce_id">

                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary', 'name' => 'introduce-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
<!--            </div>-->
        </div>
    </div>
</div>
