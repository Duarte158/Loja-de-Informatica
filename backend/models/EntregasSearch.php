<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Entregas;

class EntregasSearch extends Entregas
{
    public $estado;

    public function rules()
    {
        return [
            [['estado'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Entregas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['estado' => $this->estado]);
        }

        return $dataProvider;
    }
}
