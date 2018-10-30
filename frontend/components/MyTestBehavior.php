<?php
/**
 * Created by PhpStorm.
 * User: guozhenming
 * Date: 2018/10/30
 * Time: 7:35 PM
 */

namespace frontend\components;


use yii\base\Behavior;

class MyTestBehavior extends Behavior
{
    public $owner = 'i want you';

    public function haveOne()
    {
        return 'i have a litter girl';
    }
}