<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Companies;

/**
 * NotesSearch represents the model behind the search form of `common\models\Notes`.
 */
class NotesSearch extends Notes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['_id'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name', 'description', 'authorId'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Notes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '_id' => $this->_id,
            'authorId' => $this->authorId,
            'type' => $this->type,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
