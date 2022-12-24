<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'b_OBWIyY6Lu9OiQqjBBta6IsBGAqiiqE',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            // 'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            // 'authTimeout' => 60*30,
            'loginUrl' => ['admin/login'],
            // 'identityCookie' => [
            //     'name' => '_panelAdministrator',
            // ]
        ],
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'rules' => array(
                '' => 'main/home',
                '/<language:(en|de|nl)>?' => 'main/home',
                'main/captcha' => 'main/captcha',
                'admin/?' => 'admin/main/index',
                'admin/dashboard' => 'admin/main/dashboard',
                'admin/lang' => 'admin/main/lang',
                'admin/lang/create' => 'admin/main/lang-create',
                'admin/lang/edit/<id:\d+>' => 'admin/main/lang-edit',
                'admin/lang/delete/<id:\d+>' => 'admin/main/lang-delete',
                'admin/lang/default/<id:\d+>' => 'admin/main/is-default',
                'admin/page' => 'admin/main/page',
                'admin/page/edit' => 'admin/main/page-edit',
                'admin/user' => 'admin/main/user',
                'admin/login' => 'admin/main/login',
                'admin/logout' => 'admin/main/logout',
                [
                    'pattern' => '/index',
                    'route' => 'main/index',
                    'suffix' => '.html',
                ], 
                [
                    'pattern' => '<language:\w+>/index',
                    'route' => 'main/index',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => '/checkout',
                    'route' => 'main/checkout',
                    'suffix' => '.html',
                ],   
                [
                    'pattern' => '<language:\w+>/checkout',
                    'route' => 'main/checkout',
                    'suffix' => '.html',
                ], 
                [
                    'pattern' => '/success',
                    'route' => 'main/success',
                    'suffix' => '.html',
                ],
                [
                    'pattern' => '<language:\w+>/success',
                    'route' => 'main/success',
                    'suffix' => '.html',
                ],   
                // '<controller:\w+>/<id:\d+>' => '<controller>/view',
                // '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
