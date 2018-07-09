<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_billing".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property int $consumer_id
 * @property string $consumer_cpf
 * @property int $contract_id
 * @property string $payment_date
 * @property string $amount
 * @property string $due_date
 *
 * @property MktConsumer $consumer
 * @property MktConsumer $consumerCpf
 * @property MktContract $contract
 */
class MktBilling extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_billing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time', 'payment_date', 'due_date'], 'safe'],
            [['consumer_id', 'consumer_cpf'], 'required'],
            [['consumer_id', 'contract_id'], 'integer'],
            [['amount'], 'number'],
            [['consumer_cpf'], 'string', 'max' => 14],
            [['consumer_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktConsumer::className(), 'targetAttribute' => ['consumer_id' => 'id']],
            [['consumer_cpf'], 'exist', 'skipOnError' => true, 'targetClass' => MktConsumer::className(), 'targetAttribute' => ['consumer_cpf' => 'cpf']],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktContract::className(), 'targetAttribute' => ['contract_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'consumer_id' => Yii::t('app', 'Consumer ID'),
            'consumer_cpf' => Yii::t('app', 'Consumer Cpf'),
            'contract_id' => Yii::t('app', 'Contract ID'),
            'payment_date' => Yii::t('app', 'Payment Date'),
            'amount' => Yii::t('app', 'Amount'),
            'due_date' => Yii::t('app', 'Due Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsumer()
    {
        return $this->hasOne(MktConsumer::className(), ['id' => 'consumer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsumerCpf()
    {
        return $this->hasOne(MktConsumer::className(), ['cpf' => 'consumer_cpf']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(MktContract::className(), ['id' => 'contract_id']);
    }
}
