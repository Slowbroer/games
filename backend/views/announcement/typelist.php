<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/11/11
 * Time: 下午4:39
 */


use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>


<script>
    function load_type_model(id = 0) {
        $.ajax({
            url:"index.php?r=announcement/updatetype&id="+id,
            success:function (data) {
                data = eval("("+data+")");
                $("#anntypeform-type_name").val(data.type_name);
                $("#anntypeform-id").val(data.id);
                $("#myModal").modal("show");
            },
            error:function (data) {
                alert("加载出错，请刷新！");
            }
        });
        return false;
    }

    $(function (e) {
       $("#typeForm").on("beforeSubmit",function () {
           $.ajax({
               url:$(this).attr("action"),
               data:$(this).serialize(),
               type:$(this).attr("method"),
               success:function (data) {
                    if(data)
                    {
                        location.href = "index.php?r=announcement/typelist"
                    }
               },
               error:function (data) {

               }
           });
           return false;
       });
    });

</script>


<div class="panel panel-success" style="margin: 20px auto;width: 95%">
    <?php foreach($lists as $list){ ?>
        <div class="panel-heading">
            <a href="#" onclick="load_type_model(<?= $list['id']?>)"><?= $list['name'] ?></a>
            <a style="float: right;padding-left: 10px" href="#" onclick="del_blog(<?php echo $list['id'] ?>)">删除</a>
        </div>
    <?php } ?>
</div>

<div style="margin: 10px auto">
    <a href="#" onclick="load_type_model()" >
        <button type="button" class="btn btn-info">新建公告类型</button>
    </a>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div>
                <?php $form = ActiveForm::begin(['id'=>"typeForm",'action'=>Url::toRoute("announcement/updatetype")]); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">公告类型编辑框</h4>
                </div>
                <div class="modal-body">
                    <?= $form->field($model,"id")->hiddenInput()->label(false);?>

                    <span>类型名称：</span>

                    <?= $form->field($model,"type_name",['options'=>['style'=>"display:inline-block"]])->textInput()->label(false);?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">确定</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


