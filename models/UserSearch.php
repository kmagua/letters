<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'organization_id'], 'integer'],
            [['first_name', 'other_names', 'designation', 'id_number', 'email_address', 'personal_number', 'id_number_upload', 'password', 'role', 'last_login_date', 'status'], 'safe'],
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
        $query = User::find();

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
        if(in_array(strtolower(\Yii::$app->user->identity->role),['subscriber', 'aor'])){
            $this->organization_id = \Yii::$app->user->identity->organization->id;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'last_login_date' => $this->last_login_date,
        ]);
        
        

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'other_names', $this->other_names])
            ->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'id_number', $this->id_number])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'personal_number', $this->personal_number])
            ->andFilterWhere(['like', 'id_number_upload', $this->id_number_upload])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
