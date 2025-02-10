<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodoenvio".
 *
 * @property int $id
 * @property string $nome
 * @property string $valor
 *
 * @property Entregas[] $entregas
 */
class Metodoenvio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodoenvio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'valor'], 'required'],
            [['nome', 'valor'], 'string', 'max' => 45],
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
            'valor' => 'Valor',
        ];
    }

    /**
     * Gets query for [[Entregas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntregas()
    {
        return $this->hasMany(Entregas::class, ['envio_id' => 'id']);
    }
}
