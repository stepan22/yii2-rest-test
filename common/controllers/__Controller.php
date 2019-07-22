<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Base controller
 */
class Controller extends Controller
{
	public $searchModel = [];
	public $dataProvider = [];

	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

	public function beforeAction($action)
	{
		// $this->layout = '@app/themes/default/layouts/main.php';
		if (Yii::$app->getUser()->isGuest) {
			$request = Yii::$app->getRequest();
			// исключаем страницу авторизации или ajax-запросы
			if (!($request->getIsAjax() || strpos($request->getUrl(), 'login') !== false)) {
				Yii::$app->getUser()->setReturnUrl($request->getUrl());
			}
		}

		return parent::beforeAction($action);
	}
}