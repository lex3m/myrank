<?php

$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

$authClient = require(__DIR__ . '/authClient.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
	'request' => [
	    'csrfParam' => '_csrf-frontend',
	],
	'user' => [
	    'identityClass' => 'frontend\models\User',
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
		    'levels' => ['error', 'warning'],
		],
	    ],
	],
	'errorHandler' => [
	    'errorAction' => 'site/error',
	],
	'urlManager' => [
	    'enablePrettyUrl' => true,
	    'showScriptName' => false,
	    //'enableStrictParsing' => true,
	    'rules' => [
		'GET article' => 'article/index',
		'GET article/<id:\d+>' => 'article/view',
		'<view:help>' => 'static/page',
		'<view:feedback>' => 'static/page',
		'<view:legalinfo>' => 'static/page',
		'<view:aboutus>' => 'static/page',
		'<view:contacts>' => 'static/page'
	    ],
	],
	'assetManager' => [
	    'bundles' => [
		'yii\web\JqueryAsset' => [
		    'js' => []
		],
	    ],
	],
	'authClientCollection' => $authClient,
	'rating' => [
	    'class' => 'frontend\components\Rating',
	],
    ],
    'modules' => [
	'debug' => [
	    'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '93.79.223.10']
	]
    ],
    'params' => $params,
];
