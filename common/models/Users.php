<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

class Users extends ActiveRecord implements IdentityInterface
{
    const STATUS_TRUE = 1;
    const STATUS_FALSE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    private $_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
		return [
            [['_id'], 'integer'],
            
            [['email'], 'trim'],
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'This email address has already been taken.')],
            [['email'], 'string', 'max' => 100],
            
            [['last_name'], 'match', 'pattern' => '/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u'],
            // [['last_name'], 'required', 'message' => Yii::t('app', 'Please choose a last name.')],
            [['last_name'], 'string', 'min' => 2, 'max' => 50],

            [['first_name'], 'match', 'pattern' => '/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u'],
            // [['first_name'], 'required', 'message' => Yii::t('app', 'Please choose a first name.')],
            [['first_name'], 'string', 'min' => 2, 'max' => 50],
            
            [['createdAt', 'updatedAt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'lastName' => Yii::t('app', 'Last Name'),
            'firstName' => Yii::t('app', 'First Name'),
            'email' => Yii::t('app', 'Email'),
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
            'email',
            'firstName',
            'lastName',
            'createdAt' => function ($model) {
                $createdAt = new DateTime($model->createdAt);
                return $createdAt->format(DateTime::ISO8601);
            },
        ];

        return $fields;
    }
}
