<?php
/**
 * Created by PhpStorm.
 * User: guozhenming
 * Date: 2018/10/16
 * Time: 2:03 PM
 */

namespace frontend\controllers;


use yii\web\Controller;

class OfflineController extends Controller
{
    public function actionNotice($params1 = '', $params2 = '')
    {
        echo $params1.$params2;
    }
}