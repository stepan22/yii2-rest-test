<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'smartypanel-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
	'controllerNamespace' => 'api\controllers',
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
		'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',            
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 60 * 30,
            'storageMap' => [
                'user_credentials' => 'api\modules\oauth2\models\OAuth2',
            ],
            'grantTypes' => [
				'client_credentials' => [
					'class' => 'OAuth2\GrantType\ClientCredentials',
					'allow_public_clients' => false
				],
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\modules\oauth2\models\OAuth2',
			'enableSession' => false,
            'enableAutoLogin' => false,
        ],
		'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
				'oauth2/<action:\w+>' => 'oauth2/rest/<action>',
				'handler/<action:\w+>' => 'v1/handler/<action>',
				'handler/<action:\w+>/<token:\w+>' => 'v1/handler/<action>',
                [ 'class' => 'yii\rest\UrlRule', 'controller' => ['v1/user'], 'extraPatterns' => ['GET search' => 'search'], 'tokens' => [ '{id}' => '<id:\\w+>' ], /*'pluralize' => false*/ ],
				'handler' => 'v1/handler',
            ],        
        ],
		'request' => [
			'class' => '\yii\web\Request',
			'enableCookieValidation' => false,
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			],
		],
    ],
    'params' => $params,
];