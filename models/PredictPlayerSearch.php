<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PredictPlayer;

/**
 * PredictPlayerSearch represents the model behind the search form of `app\models\PredictPlayer`.
 */
class PredictPlayerSearch extends PredictPlayer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'player_id', 'score', 'sort_order'], 'integer'],
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
        $query = PredictPlayer::find()->orderBy(['sort_order'=>'ASC']);

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
            'player_id' => $this->player_id,
            'score' => $this->score,
            'sort_order' => $this->sort_order,
        ]);

        return $dataProvider;
    }

    public function predictview($params)
    {
        $query = PredictPlayer::find()->where(['not', ['score' => null]])->orderBy(['sort_order' => 'ASC']);

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
            'player_id' => $this->player_id,
            'score' => $this->score,
            'sort_order' => $this->sort_order,
        ]);

        return $dataProvider;
    }
}
