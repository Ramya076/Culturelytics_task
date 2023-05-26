<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "players".
 *
 * @property int $id
 * @property string $name
 * @property int $jersey_no
 * @property string $type
 * @property int|null $score
 * @property int|null $sort_order
 */
class Players extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'jersey_no', 'type'], 'required'],
            [['jersey_no', 'sort_order'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255],
            ['name','unique'],
            ['jersey_no','unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'jersey_no' => 'Jersey No',
            'type' => 'Type',
            'sort_order' => 'Sort Order',
        ];
    }
}
