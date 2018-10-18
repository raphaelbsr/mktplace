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
 * @property int $contract_id
 * @property string $payment_date
 * @property string $amount
 * @property string $due_date
 * @property string $paymentid
 *
 * @property MktConsumer $consumer 
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
            [['create_time', 'update_time', 'payment_date', 'due_date', 'paymentid'], 'safe'],            
            [['consumer_id', 'contract_id'], 'integer'],
            [['amount'], 'number'],            
            [['consumer_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktConsumer::className(), 'targetAttribute' => ['consumer_id' => 'id']],            
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
            'contract_id' => Yii::t('app', 'Contract ID'),
            'payment_date' => Yii::t('app', 'Payment Date'),
            'amount' => Yii::t('app', 'Amount'),
            'due_date' => Yii::t('app', 'Due Date'),
            'paymentid' => Yii::t('app', 'Paymentid'),
        ];
    }

     public function expiredDays(){
        $dueDate = DateTime::createFromFormat('Y-m-d', $this->due_date);
        $interval = $dueDate->diff(new \DateTime());
        return ( $interval->invert ? $interval->days * -1 : $interval->days ) ;
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
    public function getContract()
    {
        return $this->hasOne(MktContract::className(), ['id' => 'contract_id']);
    }
}
