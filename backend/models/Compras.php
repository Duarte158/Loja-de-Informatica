<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "compras".
 *
 * @property int $id
 * @property string $data
 * @property float $valorTotal
 * @property int $estado
 * @property int $fornecedores_id
 * @property int $numero
 *
 * @property Fornecedor $fornecedores

 * @property Linhafaturafornecedor[] $linhafaturafornecedors
 */
class Compras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'estado', 'fornecedores_id', 'numero'], 'integer'],
            [['data'], 'safe'],
            [['valorTotal'], 'number'],
            [['id'], 'unique'],
            [['fornecedores_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fornecedor::class, 'targetAttribute' => ['fornecedores_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'valorTotal' => 'Valor Total',
            'estado' => 'Estado',
            'fornecedores_id' => 'Fornecedores ID',
            'numero' => 'Numero',
        ];
    }

    /**
     * Gets query for [[Fornecedores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedores()
    {
        return $this->hasOne(Fornecedor::class, ['ID' => 'fornecedores_id']);
    }

    /**
     * Gets query for [[Linhacompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacompras()
    {
        return $this->hasMany(Linhacompras::class, ['compra_id' => 'id']);
    }

    /**
     * Gets query for [[Linhafaturafornecedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturafornecedors()
    {
        return $this->hasMany(Linhafaturafornecedor::class, ['faturafornecedor_id' => 'id']);
    }
}
