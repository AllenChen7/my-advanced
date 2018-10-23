<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    // 应用名称
    'name' => 'My Adv',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                ],
                [
                    // 当错误等级为 error 时发送邮件到目标邮件
                    // 需配置好邮件配置
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'mailer' => 'mailer',
                    'message' => [
                        'from' => ['17621598511@163.com'],
                        'to' => ['1175195335@qq.com'],
                        'subject' => '系统发生错误',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
//    'catchAll' => [
//        'offline/notice',
//        'param1' => 'value1',
//        'param2' => 'value2',
//    ],
    'params' => $params,
];
