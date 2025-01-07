<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "entregas".
 *
 * @property int $id
 * @property string $estado
 * @property string|null $data
 * @property int $carrinho_id
 * @property string|null $nome
 * @property string|null $morada
 * @property string|null $cidade
 * @property string|null $codPostal
 * @property int|null $contacto
 * @property int|null $user_id
 *
 * @property Carrinhocompras $carrinho
 * @property User $user
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
            [['estado', 'carrinho_id'], 'required'],
            [['data'], 'safe'],
            [['carrinho_id', 'contacto', 'user_id'], 'integer'],
            [['estado', 'nome', 'morada', 'cidade', 'codPostal'], 'string', 'max' => 45],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhocompras::class, 'targetAttribute' => ['carrinho_id' => 'id']],
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
            'estado' => 'Estado',
            'data' => 'Data',
            'carrinho_id' => 'Carrinho ID',
            'nome' => 'Nome',
            'morada' => 'Morada',
            'cidade' => 'Cidade',
            'codPostal' => 'Cod Postal',
            'contacto' => 'Contacto',
            'user_id' => 'User ID',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
