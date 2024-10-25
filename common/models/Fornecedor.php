<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fornecedor".
 *
 * @property int $ID
 * @property string $designacaoSocial
 * @property string $email
 * @property int $nif
 * @property string $morada
 * @property string $capitalSocial
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designacaoSocial', 'email', 'nif', 'morada', 'capitalSocial'], 'required'],
            [['nif'], 'integer'],
            [['designacaoSocial', 'email', 'morada', 'capitalSocial'], 'string', 'max' => 45],
            [['nif'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'designacaoSocial' => 'Designacao Social',
            'email' => 'Email',
            'nif' => 'Nif',
            'morada' => 'Morada',
            'capitalSocial' => 'Capital Social',
        ];
    }
}
