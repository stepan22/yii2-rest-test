<?php
namespace api\modules\v1\controllers;

use api\modules\oauth2\controllers\OAuth2Controller;
use yii\filters\AccessControl;

/**
 * User Controller API
 *
 * @author Stepan Karasov <stepan.karasov@gmail.com>
 */
class UserController /* extends OAuth2Controller */
{
    public $modelClass = 'common\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Users',
    ];

/*
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['index', 'view', 'update', 'delete'],
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['view'],
                    'allow' => true,
                    'roles' => ['?','@'],
                ],
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['delete'],
                    'allow' => true,
                    'roles' => ['administrator'],
                ],
            ],
        ];

        return $behaviors;
    }
*/

    public function actions()
    {
        $actions = parent::actions();

        unset(
            $actions['delete'],
            $actions['create']
        );

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $query = $modelClass::find();
        if (!empty($filter)) {
            $query->andWhere($filter);
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }

}
