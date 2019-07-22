<?php
namespace api\modules\oauth2\controllers;

use yii\rest\ActiveController;

use yii\helpers\ArrayHelper;
use yii\web\Response;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use filsh\yii2\oauth2server\filters\auth\CompositeAuth;

//use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\RateLimiter;
use yii\filters\ContentNegotiator;

class OAuth2Controller extends ActiveController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => CompositeAuth::className(),
                //'only' => ['view-full', 'create', 'update', 'delete'], // 'index', 'view'
                //'only' => ['index', 'view'],
                'except' => ['view', 'options'],
                'authMethods' => [
                    ['class' => HttpBasicAuth::className()],
                    ['class' => HttpBearerAuth::className()],
                    ['class' => QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
                ]
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'exceptionFilter' => [
                'class' => ErrorToExceptionFilter::className()
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
                'enableRateLimitHeaders' => false,
            ],
            'bootstrap' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
                'languages' => [
                    'ru',
                    'en',
                ],
            ]
        ]);
    }
}