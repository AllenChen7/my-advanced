<?php
/**
 * Created by PhpStorm.
 * User: guozhenming
 * Date: 2018/10/15
 * Time: 11:17 AM
 */
use yii\helpers\Html;

?>

<p>You have entered the following information:</p>

<ul>
    <li>
        <label>
            Name:<?=Html::encode($model->name)?>
        </label>
    </li>
    <li>
        <label>
            Email:<?=Html::encode($model->email)?>
        </label>
    </li>
</ul>
