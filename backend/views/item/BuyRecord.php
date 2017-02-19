<?php
/**
 * Created by PhpStorm.
 * User: Slowbro
 * Date: 17/2/18
 * Time: 下午5:12
 */

use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'RecordForm']); ?>

<?= $form->field($model,"user_name")?>


<?php ActiveForm::end();?>
