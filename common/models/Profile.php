<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $idprofile
 * @property string|null $name
 * @property int|null $nif
 * @property string|null $address
 * @property int|null $contact
 * @property int $user_id
 * @property string|null $codpostal
 * @property string|null $cidade
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
            [['nif', 'contact', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['name', 'address', 'codpostal', 'cidade'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idprofile' => 'Idprofile',
            'name' => 'Name',
            'nif' => 'Nif',
            'address' => 'Address',
            'contact' => 'Contact',
            'user_id' => 'User ID',
            'codpostal' => 'Codpostal',
            'cidade' => 'Cidade',
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