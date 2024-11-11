<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhocompras".
 *
 * @property int $id
 * @property string $data
 * @property float $valorTotal
 * @property string $estado
 * @property int|null $opcaoEntrega
 * @property float $valorIva
 * @property int $user_id
 * @property string|null $metodoPagamento
 *
 * @property Entregas[] $entregas
 * @property Linhacarrinho[] $linhacarrinhos
 * @property User $user
 */
class Carrinhocompras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhocompras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'valorTotal', 'estado', 'valorIva', 'user_id'], 'required'],
            [['data'], 'safe'],
            [['valorTotal', 'valorIva'], 'number'],
            [['opcaoEntrega', 'user_id'], 'integer'],
            [['estado', 'metodoPagamento'], 'string', 'max' => 45],
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
            'valorTotal' => 'Valor Total',
            'estado' => 'Estado',
            'opcaoEntrega' => 'Opcao Entrega',
            'valorIva' => 'Valor Iva',
            'user_id' => 'User ID',
            'metodoPagamento' => 'Metodo Pagamento',
        ];
    }

    /**
     * Gets query for [[Entregas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntregas()
    {
        return $this->hasMany(Entregas::class, ['carrinho_id' => 'id']);
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['carrinho_id' => 'id']);
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
