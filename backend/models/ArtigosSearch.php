<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Artigos;

class ArtigosSearch extends Artigos\
{
    public function rules()
    {
        return [
            [['id', 'nome', 'preco'], 'safe'], // Adapte as regras aos campos da sua tabela de artigos
        ];
    }

    public function search($params)
    {
        $query = Artigos::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'nome', $this->nome])
                ->andFilterWhere(['like', 'preco', $this->preco]);
        }

        return $dataProvider;
    }
}
