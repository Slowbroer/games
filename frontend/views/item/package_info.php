<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 16/12/11
 * Time: 下午8:35
 */

use yii\bootstrap\Html;
?>

<div>
    <?php foreach ($info as $key=>$value) {
//        var_dump($key);
        if ($value !== null && ($key=='Name' || $key=='BW' || $key=='Prise')) { ?>
            <p><?php echo Html::encode($value); ?></p>
        <?php
        }
    }
    ?>
</div>
