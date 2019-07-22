<?php
namespace api\modules\v1\controllers;

use yii\rest\Controller;

use common\models\UsersSearch;
/**
 * User Controller API
 *
 * @author Stepan Karasov <stepan.karasov@gmail.com>
 */
class UserController extends Controller
{
    public $modelClass = 'common\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Users',
    ];

    // Переопределяем действия
    public function actions()
    {
        $actions = parent::actions();

        unset(
            $actions['index'],
        );

        return $actions;
    }

    // Выдаем результат запроса с фильтром common\models\UsersSearch
    public function actionIndex()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $users = new UsersSearch();

        return $users->search($requestParams);
    }
}
