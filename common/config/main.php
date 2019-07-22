<?php
return [
    'timezone' => 'UTC',
	'bootstrap' => ['log'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
		'request' => [
            'csrfParam' => '_csrf-smartypanel',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => [
				'name' => '_identity',
				'httpOnly' => true,
				'domain' => '.smartypanel.ru',
				// 'path' => '/',
			],
        ],
        'session' => [
			'class' => 'yii\web\Session',
			'cookieParams' => [
				'httpOnly' => true,
				'domain' => '.smartypanel.ru',
				// 'path' => '/',
			],
            // this is the name of the session cookie used for login on the backend
            'name' => 'smartypanel',
			
        ],
		'assetManager' => [
			'class' => 'yii\web\AssetManager',
			'linkAssets' => true,
		],
        'cache' => [
            // 'class' => 'yii\caching\FileCache',
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                ],
            ],
            'useMemcached' => true,
        ],
		'authManager' => [
            'class' => 'yii\rbac\DbManager',
			'cache' => 'cache' //Включаем кеширование 
        ],
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'UTC',
            //'timeZone' => 'Asia/Vladivostok',
			'dateFormat' => 'php:d.m.Y',
			'datetimeFormat' => 'php:d.m.Y H:i:s',
			'timeFormat' => 'php:H:i:s',
		],
    ],
];
