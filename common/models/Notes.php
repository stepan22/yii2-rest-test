<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

class Notes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return '{{%notes}}';
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['note/view', 'id' => $this->_id], true),
        ];
    }
/*
	public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['_id'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name', 'description', 'authorId'], 'string'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'authorId' => Yii::t('app', 'Author'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        return [
            '_id',
            'name',
            'description',
            'author',
            'author' => function ($model) {
                return $model->getAuthor;
            },
            'createdAt',
        ];

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        if (!\Yii::$app->user->can('administrator')) {
            throw new ForbiddenHttpException(Yii::t('app', 'Access denied'));
        }

        return [
            'updatedAt'
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['_id' => 'authorId']);
    }
}
