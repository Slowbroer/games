<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/1/16
 * Time: 上午10:44
 */


?>



<h3>
    系统设置
</h3>

<div>
    <?php foreach($lists as $list){ ?>
    <div class="form-group" style="width: 80%;padding: 20px 0;">
        <label for="inputEmail3" class="col-sm-2 control-label"><?= $list['name'];?></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" value="<?php echo $list['value'];?>" style="width: 300px;" onblur="updateConfig(<?= $list['id'];?>,this);">
        </div>
    </div>
    <?php } ?>
</div>

<script>
    function updateConfig(id,config) {
        var configValue = $(config).val();
        $.ajax({
            url:"index.php?r=site/update-config&id="+id+"&value="+configValue,
            success:function (data) {
                data = eval("("+data+")");
                if(data.code == 0)
                {
                    alert("更新失败");
                }
            },
            error:function () {
                alert("更新失败");
            }
        })
    }
</script>
