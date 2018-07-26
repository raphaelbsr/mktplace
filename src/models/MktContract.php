<?php

namespace raphaelbsr\mktplace\models;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "mkt_contract".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property string $product_key
 * @property int $consumer_id
 * @property string $consumer_cpf
 * @property int $product_id
 * @property int $plan_id
 * @property int $payment_plan_id
 * @property string $expire_at
 *
 * @property MktBilling[] $mktBillings
 * @property MktConsumer $consumer
 * @property MktConsumer $consumerCpf
 * @property MktPaymentPlan $paymentPlan
 * @property MktProduct $product
 * @property MktPlan $plan
 */
class MktContract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_contract';
    }

    public function beforeSave($insert) {
        if($insert){
            $this->product_key = Uuid::uuid4()->toString();
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time', 'expire_at'], 'safe'],
            [['consumer_id'], 'required'],
            [['consumer_id', 'product_id', 'payment_plan_id','plan_id'], 'integer'],
            [['product_key'], 'string', 'max' => 64],            
            [['consumer_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktConsumer::className(), 'targetAttribute' => ['consumer_id' => 'id']],            
            [['payment_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktPaymentPlan::className(), 'targetAttribute' => ['payment_plan_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktProduct::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'product_key' => Yii::t('app', 'Product Key'),
            'consumer_id' => Yii::t('app', 'Consumer ID'),            
            'product_id' => Yii::t('app', 'Product ID'),
            'payment_plan_id' => Yii::t('app', 'Payment Plan ID'),
            'expire_at' => Yii::t('app', 'Expire At'),
            'plan_id' => Yii::t('app', 'Plan'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktBillings()
    {
        return $this->hasMany(MktBilling::className(), ['contract_id' => 'id']);
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
    public function getPaymentPlan()
    {
        return $this->hasOne(MktPaymentPlan::className(), ['id' => 'payment_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(MktProduct::className(), ['id' => 'product_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(MktPlan::className(), ['id' => 'plan_id']);
    }
    
    public function calcAmount(){
        $finalPrice = 0;
        $price = $this->plan->price;
        if($this->paymentPlan->discount_percentage > 0 ){            
            $finalPrice = ($price * $this->paymentPlan->discount_percentage) / 100;            
        }        
        return $price - $finalPrice;
    }
}
