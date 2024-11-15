<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhacarrinho".
 *
 * @property int $id
 * @property int|null $quantidade
 * @property float|null $valor
 * @property int|null $referencia
 * @property int|null $carrinho_id
 * @property int|null $artigo_id
 * @property float|null $valorTotal
 *
 * @property Artigos $artigo
 * @property Carrinhocompras $carrinho
 */
class Linhacarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhacarrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'referencia', 'carrinho_id', 'artigo_id'], 'integer'],
            [['valor', 'valorTotal'], 'number'],
            [['artigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigos::class, 'targetAttribute' => ['artigo_id' => 'Id']],
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
            'quantidade' => 'Quantidade',
            'valor' => 'Valor',
            'referencia' => 'Referencia',
            'carrinho_id' => 'Carrinho ID',
            'artigo_id' => 'Artigo ID',
            'valorTotal' => 'Valor Total',
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
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinhocompras::class, ['id' => 'carrinho_id']);
    }

    public function getTotalLine(){

        return $this->quantidade * $this->valor;
    }



    public function getIvaValue()
    {
        $iva = $this->artigo !== null && $this->artigo->iva !== null ? $this->artigo->iva->percentagem : 0;
        return $this->quantidade * $this->valor * $iva/100;
    }

    public function getTotalValueWithIva()
    {
        return $this->getIvaValue() + $this->getTotalLine();
    }
}
