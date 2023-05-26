<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Players;

/**
 * PlayersSearch represents the model behind the search form of `app\models\Players`.
 */
class PlayersSearch extends Players
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'jersey_no', 'sort_order'], 'integer'],
            [['type'], 'safe'],
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
        $query = Players::find()
        ->leftJoin('predict_player', 'predict_player.player_id = players.id')
        ->where(['predict_player.player_id' => null])
        ->orderBy(['sort_order' => SORT_ASC]);
    

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
            'name' => $this->name,
            'jersey_no' => $this->jersey_no,
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
    
    
}
