<?php
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker as jd;
use yii\helpers\Url;
use yii\bootstrap\Alert;
?>

<?=Html::encode($message)?>

<?= DatePicker::widget([
    'name' => 'check_issue_date',
    'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'Select issue date ...'],
    'language' => 'zh-CN',
    'pluginOptions' => [
        'format' => 'yyyy-m-d',
        'todayHighlight' => true
    ]
]);?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'username') ?>

<?= $form->field($model, 'password_hash')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Login', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?= jd::widget(['name' => 'attributeName']) ?>
<br/>
<?= Url::to([''], true);?>
<br>
<?= Url::canonical()?>
<br>
<?php Url::remember(); echo Url::previous();?>
<br>
<?= Yii::$app->request->userHost?>
<br>
<?= Yii::$app->request->userIP?>
<br>
<?= Yii::$app->request->userAgent?>
<?= Alert::widget([
    'options' => ['class' => 'alert-info'],
    'body' => '你好，世界',
]); ?>

<?php //Yii::error('你猜猜发生了什么', __METHOD__); ?>

<?php //throw new \yii\web\NotFoundHttpException('并不存在');?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'auth_key')->fileInput() ?>

<button>Submit</button>

<?php ActiveForm::end() ?>


<form action="/site/upload" method="post" enctype="multipart/form-data">
    <input name="file" type="file">
    <input type="submit" value="tijiao">
</form>
