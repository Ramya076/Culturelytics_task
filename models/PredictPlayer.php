<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "predict_player".
 *
 * @property int $id
 * @property int|null $player_id Reference of table 'players'
 * @property int|null $score
 * @property int|null $sort_order
 *
 * @property Players $player
 */
class PredictPlayer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'predict_player';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['player_id', 'score', 'sort_order'], 'integer'],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Players::class, 'targetAttribute' => ['player_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'player_id' => 'Player ID',
            'score' => 'Score',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * Gets query for [[Player]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Players::class, ['id' => 'player_id']);
    }
}
