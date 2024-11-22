<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "artigos".
 *
 * @property int $Id
 * @property string|null $nome
 * @property string|null $descricao
 * @property float|null $precoUni
 * @property int|null $stock
 * @property int|null $categoria_id
 * @property int|null $iva_id
 * @property int|null $destaque
 * @property int|null $referencia
 * @property string|null $imagem
 * @property float|null $precoFinal
 * @property int|null $marca_id
 *
 * @property Categoria $categoria
 * @property Iva $iva
 * @property Linhacarrinho[] $linhacarrinhos
 * @property Linhacompras[] $linhacompras
 * @property Linhafatura[] $linhafaturas
 * @property Marca $marca
 */
class Artigos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artigos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['precoUni', 'precoFinal'], 'number'],
            [['stock', 'categoria_id', 'iva_id', 'destaque', 'referencia', 'marca_id'], 'integer'],
            [['nome', 'descricao', 'imagem'], 'string', 'max' => 45],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
            [['marca_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::class, 'targetAttribute' => ['marca_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'precoUni' => 'Preco Uni',
            'stock' => 'Stock',
            'categoria_id' => 'Categoria ID',
            'iva_id' => 'Iva ID',
            'destaque' => 'Destaque',
            'referencia' => 'Referencia',
            'imagem' => 'Imagem',
            'precoFinal' => 'Preco Final',
            'marca_id' => 'Marca ID',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Iva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::class, ['id' => 'iva_id']);
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['artigo_id' => 'Id']);
    }

    /**
     * Gets query for [[Linhacompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacompras()
    {
        return $this->hasMany(Linhacompras::class, ['artigo_id' => 'Id']);
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['artigo_id' => 'Id']);
    }

    /**
     * Gets query for [[Marca]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarca()
    {
        return $this->hasOne(Marca::class, ['id' => 'marca_id']);
    }
}
