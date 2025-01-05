<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "compras".
 *
 * @property int $id
 * @property string|null $data
 * @property float|null $valorTotal
 * @property string|null $estado
 * @property int|null $fornecedores_id
 * @property int|null $numero
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
            [['data'], 'safe'],
            [['valorTotal'], 'number'],
            [['estado'], 'string'],
            [['fornecedores_id', 'numero'], 'integer'],
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
     * Gets query for [[Linhafaturafornecedors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturafornecedors()
    {
        return $this->hasMany(Linhafaturafornecedor::class, ['faturafornecedor_id' => 'id']);
    }
}
