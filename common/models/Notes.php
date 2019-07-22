<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

class Notes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return '{{%notes}}';
    }

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
            'author' => function ($model) {
                return $model->getAuthor;
            },
            'createdAt' => function ($model) {
                $createdAt = new DateTime($model->createdAt);
                return $createdAt->format(DateTime::ISO8601);
            },            
        ];

        return $fields;
    }

    public function getAuthor()
    {
        return $this->hasOne(Users::className(), ['_id' => 'authorId']);
    }
}
