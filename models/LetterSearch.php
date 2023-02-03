<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Letter;

/**
 * LetterSearch represents the model behind the search form of `app\models\Letter`.
 */
class LetterSearch extends Letter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'organization_id', 'response_required'], 'integer'],
            [['date', 'reference_number', 'title', 'date_received', 'letter', 'response_letter', 'status', 'date_created', 'last_modified'], 'safe'],
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
        $query = Letter::find();

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
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'date' => $this->date,
            'date_received' => $this->date_received,
            'response_required' => $this->response_required,
            'date_created' => $this->date_created,
            'last_modified' => $this->last_modified,
        ]);

        $query->andFilterWhere(['like', 'reference_number', $this->reference_number])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'letter', $this->letter])
            ->andFilterWhere(['like', 'response_letter', $this->response_letter])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
