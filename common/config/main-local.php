<?php
return [
	//'timeZone' => 'Asia/Vladivostok',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=smartypanel',
            'username' => 'smartypanel',
            'password' => '',
            'charset' => 'utf8mb4',

            // Schema cache options (for production environment)
            'enableSchemaCache' => false,
            //'schemaCache' => 'cache',
            // Enabling Table Schema Caching (Disable SHOW CREATE TABLE) / Кеширование схем данных
            'schemaCacheDuration' => 3600,
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://@localhost:27017/mydatabase',
            'options' => [
                "username" => "user",
                "password" => "sptest"
            ]
        ],
		/*
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
		*/
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
			'htmlLayout' => '@common/mail/layouts/html',
			//'textLayout' => '@common/mail/layouts/html',
			'messageConfig' => [
				'charset' => 'UTF-8',
				'from' => ['support@smartypanel.ru' => 'SmartyPanel Support'],
			],
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.yandex.ru',
				'username' => 'support@smartypanel.ru',
				'password' => '',
				'port' => '465',
				'encryption' => 'ssl',
			  ],
		],
    ],
];
