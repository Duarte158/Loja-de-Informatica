<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhocompras".
 *
 * @property int $id
 * @property string|null $data
 * @property float|null $valorTotal
 * @property string|null $estado
 * @property int|null $opcaoEntrega
 * @property float|null $valorIva
 * @property int|null $user_id
 * @property string|null $metodoPagamento
 * @property int|null $envio_id
 *
 * @property Entregas[] $entregas
 * @property Metodoenvio $envio
 * @property Fatura[] $faturas
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
            [['data','envio_id', 'valor_total'], 'safe'],
            [['valorTotal', 'valorIva'], 'number'],
            [['opcaoEntrega', 'user_id', 'envio_id'], 'integer'],
            [['estado', 'metodoPagamento'], 'string', 'max' => 45],
            [['envio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodoenvio::class, 'targetAttribute' => ['envio_id' => 'id']],
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
            'envio_id' => 'Envio ID',
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
     * Gets query for [[Envio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEnvio()
    {
        return $this->hasOne(Metodoenvio::class, ['id' => 'envio_id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['carrinho_id' => 'id']);
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

    public function getTotalValue()
    {
        $total = 0;
        foreach ($this->linhacarrinhos as $linha) {
            $total += $linha->getTotalLine();
        }
        return $total;
    }

    /*
        public function getTotalValue()
        {
            $total = 0;
            foreach ($this->linhacarrinhos as $linha) {
                $total += $linha->getTotalValueWithIva();
            }
            return $total;
        }
    */

    public function getTotalIva()
    {
        $totalIva = 0;
        foreach ($this->linhacarrinhos as $linha) {
            $totalIva += $linha->getIvaValue();
        }
        return $totalIva;
    }

    public function getItemCount()
    {
        return \common\models\Linhacarrinho::find()
            ->where(['carrinho_id' => $this->id])
            ->sum('quantidade');
    }



}
