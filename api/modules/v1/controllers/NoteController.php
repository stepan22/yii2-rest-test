<?php
namespace api\modules\v1\controllers;


use Yii;
use yii\data\ActiveDataProvider;

use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

use common\models\NotesSearch;

/**
 * Note Controller API
 *
 * @author Stepan Karasov <stepan.karasov@gmail.com>
 */
class NoteController
{
    public $modelClass = 'common\models\Note';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'Notes',
    ];

    public function actions()
    {
        $actions = parent::actions();

        unset(
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

        $notes = new NotesSearch();
        return $model->search($requestParams);
    }

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
}
