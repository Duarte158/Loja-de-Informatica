<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhacarrinho".
 *
 * @property int $id
 * @property int $quantidade
 * @property float $valor
 * @property int $referencia
 * @property int $carrinho_id
 * @property int $artigo_id
 *
 * @property Artigos $artigos
 * @property Carrinhocompras $carrinho
 */
class LinhaCarrinho extends \yii\db\ActiveRecord
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
            [['quantidade', 'valor', 'referencia', 'carrinho_id', 'artigo_id'], 'required'],
            [['quantidade', 'referencia', 'carrinho_id', 'artigo_id'], 'integer'],
            [['valor'], 'number'],
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
        $iva = $this->artigos !== null && $this->artigos->iva !== null ? $this->artigos->iva->percentagem : 0;
        return $this->quantidade * $this->valor * $iva/100;
    }

    public function getTotalValueWithIva()
    {
        return $this->getIvaValue() + $this->getTotalLine();
    }
}
