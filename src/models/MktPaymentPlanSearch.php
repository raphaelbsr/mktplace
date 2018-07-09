<?php

namespace raphaelbsr\mktplace\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use raphaelbsr\mktplace\models\MktPaymentPlan;

/**
 * MktPaymentPlanSearch represents the model behind the search form about `app\models\MktPaymentPlan`.
 */
class MktPaymentPlanSearch extends MktPaymentPlan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'discount_percentage', 'isactive', 'season'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = MktPaymentPlan::find();

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
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'discount_percentage' => $this->discount_percentage,
            'isactive' => $this->isactive,
            'season' => $this->season,
        ]);

        return $dataProvider;
    }
}
