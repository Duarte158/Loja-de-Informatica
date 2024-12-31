<?php

namespace backend\models;

use common\models\Artigos;
use Yii;

/**
 * This is the model class for table "linhafaturafornecedor".
 *
 * @property int $id
 * @property int $quantidade
 * @property float $valor
 * @property int $referencia
 * @property int $faturafornecedor_id
 * @property int $artigo_id
 * @property float $total
 *
 * @property Artigos $artigo
 * @property Compras $faturafornecedor
 */
class Linhafaturafornecedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhafaturafornecedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'valor', 'referencia', 'faturafornecedor_id', 'artigo_id', 'total'], 'required'],
            [['quantidade', 'referencia', 'faturafornecedor_id', 'artigo_id'], 'integer'],
            [['valor', 'total'], 'number'],
            [['artigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigos::class, 'targetAttribute' => ['artigo_id' => 'Id']],
            [['faturafornecedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Compras::class, 'targetAttribute' => ['faturafornecedor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidade' => 'Quantidade',
            'valor' => 'Valor',
            'referencia' => 'Referencia',
            'faturafornecedor_id' => 'Faturafornecedor ID',
            'artigo_id' => 'Artigo ID',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[Artigo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigo()
    {
        return $this->hasOne(Artigos::class, ['Id' => 'artigo_id']);
    }

    /**
     * Gets query for [[Faturafornecedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturafornecedor()
    {
        return $this->hasOne(Compras::class, ['id' => 'faturafornecedor_id']);
    }
}
