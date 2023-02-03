<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Organization;

/**
 * OrganizationSearch represents the model behind the search form of `app\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'registered_by'], 'integer'],
            [['institution_name', 'organization_type', 'kra_pin_number', 'physical_address', 'email_address', 'postal_address', 'phone_number', 'request_letter', 'aor_appointment_letter', 'registration_charter_agreement', 'date_registered'], 'safe'],
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
        $query = Organization::find();

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
            'registered_by' => $this->registered_by,
            'date_registered' => $this->date_registered,
        ]);

        $query->andFilterWhere(['like', 'institution_name', $this->institution_name])
            ->andFilterWhere(['like', 'organization_type', $this->organization_type])
            ->andFilterWhere(['like', 'kra_pin_number', $this->kra_pin_number])
            ->andFilterWhere(['like', 'physical_address', $this->physical_address])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'postal_address', $this->postal_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'request_letter', $this->request_letter])
            ->andFilterWhere(['like', 'aor_appointment_letter', $this->aor_appointment_letter])
            ->andFilterWhere(['like', 'registration_charter_agreement', $this->registration_charter_agreement]);

        return $dataProvider;
    }
}
