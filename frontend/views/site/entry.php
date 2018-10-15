<?php
/**
 * Created by PhpStorm.
 * User: guozhenming
 * Date: 2018/10/15
 * Time: 11:20 AM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $from = ActiveForm::begin(); ?>
    <?= $from->field($model, 'name') ?>
    <?= $from->field($model, 'email') ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
