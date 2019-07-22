<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

use common\models\NotesSearch;

/**
 * Note Controller API
 *
 * @author Stepan Karasov <stepan.karasov@gmail.com>
 */
class NoteController extends Controller
{
    public $modelClass = 'common\models\Note';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Notes',
    ];

    // Переопределяем действия
    public function actions()
    {
        $actions = parent::actions();

        unset(
            $actions['index'],
            $actions['create'],
        );

        return $actions;
    }

    // Создаем из POST запроса модель common\models\Notes
    public function actionCreate()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $model = new Notes();
        $model->load($requestParams, '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new BadRequestHttpException('Failed to create');
        }
    }

    // Выдаем результат запроса с фильтром common\models\NotesSearch
    public function actionIndex()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $notes = new UsersSearch();

        return $notes->search($requestParams);
    }
}
