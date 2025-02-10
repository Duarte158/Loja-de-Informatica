<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "precoentrega".
 *
 * @property int $id
 * @property int|null $distancia_min
 * @property int|null $distancia_max
 * @property float|null $preco
 */
class Precoentrega extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'precoentrega';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distancia_min', 'distancia_max'], 'integer'],
            [['preco'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'distancia_min' => 'Distancia Min',
            'distancia_max' => 'Distancia Max',
            'preco' => 'Preco',
        ];
    }
}
