<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "entregas".
 *
 * @property int $id
 * @property string $status
 * @property string|null $data
 * @property int $carrinho_id
 *
 * @property Carrinhocompras $carrinho
 */
class Entregas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entregas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'carrinho_id'], 'required'],
            [['data'], 'safe'],
            [['carrinho_id'], 'integer'],
            [['status'], 'string', 'max' => 45],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhocompras::class, 'targetAttribute' => ['carrinho_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'data' => 'Data',
            'carrinho_id' => 'Carrinho ID',
        ];
    }

    /**
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinhocompras::class, ['id' => 'carrinho_id']);
    }
}
