<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $morada
 * @property int|null $contacto
 * @property int|null $nif
 * @property int $user_id
 * @property string|null $cidade
 * @property string|null $codPostal
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
            [['contacto', 'nif', 'user_id'], 'integer'],
            [['user_id'], 'required'],
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
