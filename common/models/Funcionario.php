<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Carrinhocompras[] $carrinhocompras
 * @property Fatura[] $faturas
 * @property Profile[] $profiles
 */
class Funcionario extends \yii\db\ActiveRecord
{
    public $password;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email', 'password'], 'string', 'max' => 255],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

    public function getCarrinhocompras()
    {
        return $this->hasMany(Carrinhocompras::class, ['user_id' => 'id']);
    }

    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['user_id' => 'id']);
    }

    public function getProfiles()
    {
        return $this->hasMany(Profile::class, ['user_id' => 'id']);
    }

    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }
}