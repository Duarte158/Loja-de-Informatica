<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string $nome
 * @property string $morada
 * @property int $contacto
 * @property int $nif
 * @property int $user_id
 * @property string $cidade
 * @property string $codPostal
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'morada', 'contacto', 'nif', 'user_id', 'cidade', 'codPostal'], 'required'],
            [['contacto', 'nif', 'user_id'], 'integer'],
            [['nome', 'morada', 'cidade', 'codPostal'], 'string', 'max' => 45],
            [['nif'], 'unique'],
            [['contacto'], 'unique'],
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
            'nome' => 'Nome',
            'morada' => 'Morada',
            'contacto' => 'Contacto',
            'nif' => 'Nif',
            'user_id' => 'User ID',
            'cidade' => 'Cidade',
            'codPostal' => 'Cod Postal',
        ];
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
