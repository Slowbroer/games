<?php
/**
 * Created by PhpStorm.
 * User: linpeiyu
 * Date: 2016-09-27
 * Time: 15:14
 */
use \yii\bootstrap\Html;


?>

<div class="panel panel-success" style="margin: 20px auto;width: 95%">
    <?php foreach($lists as $list){ ?>
        <div class="panel-heading">
            <a href="<?php echo \yii\helpers\Url::toRoute('announcement/edit').'&id='.$list['announcement_id'] ?>"><?= $list['type_name']."-".$list['name'] ?></a>
            <a style="float: right;padding-left: 10px" href="#" onclick="del_blog(<?php echo $list['announcement_id']; ?>)">删除</a>
        </div>
    <?php } ?>
</div>

<div style="text-align: center">
    <?php
    echo \yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
    ]);
    ?>
</div>

<div style="margin: 10px auto">
    <a href="index.php?r=announcement/edit">
        <button type="button" class="btn btn-info">新建公告</button>
    </a>
</div>



<script type="text/javascript">
    function del_blog(id)
    {
        confirm("Are you sure to delete this blog");
        $.ajax(
            {

                url:'index.php?r=announcement/del',
                data:{id:id},
                type:"POST",
                success:function(data){
                    console.log(data);
                    if (data)
                    {
                        alert("删除成功");
                        location.href="index.php?r=announcement/list";
                    }
                    else
                    {
                        alert("删除失败");
                    }

                },
                error:function(){
                    alert("delete failed")
                }

            }
        );
    }
</script>