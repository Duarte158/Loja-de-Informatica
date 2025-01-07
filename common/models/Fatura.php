<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fatura".
 *
 * @property int $id
 * @property string $data
 * @property int $user_id
 * @property int $metodoPagamento_id
 * @property int $carrinho_id
 *
 * @property Carrinhocompras $carrinho
 * @property Linhafatura[] $linhafaturas
 * @property Metodopagamento $metodoPagamento
 * @property User $user
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'user_id', 'metodoPagamento_id', 'carrinho_id'], 'required'],
            [['data'], 'safe'],
            [['user_id', 'metodoPagamento_id', 'carrinho_id'], 'integer'],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhocompras::class, 'targetAttribute' => ['carrinho_id' => 'id']],
            [['metodoPagamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['metodoPagamento_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'metodoPagamento_id' => 'Metodo Pagamento ID',
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

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['fatura_id' => 'id']);
    }

    /**
     * Gets query for [[MetodoPagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoPagamento()
    {
        return $this->hasOne(Metodopagamento::class, ['id' => 'metodoPagamento_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
