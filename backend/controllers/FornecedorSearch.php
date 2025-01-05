<?php

namespace backend\controllers;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Fornecedor;

/**
 * FornecedorSearch represents the model behind the search form of `backend\models\Fornecedor`.
 */
class FornecedorSearch extends Fornecedor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'nif'], 'integer'],
            [['designacaoSocial', 'email', 'morada', 'capitalSocial'], 'safe'],
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
        $query = Fornecedor::find();

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
            'ID' => $this->ID,
            'nif' => $this->nif,
        ]);

        $query->andFilterWhere(['like', 'designacaoSocial', $this->designacaoSocial])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'morada', $this->morada])
            ->andFilterWhere(['like', 'capitalSocial', $this->capitalSocial]);

        return $dataProvider;
    }
}
