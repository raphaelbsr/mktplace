<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_product".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property string $name
 * @property int $payment_group_id
 * @property int $isactive
 *
 * @property MktContract[] $mktContracts
 * @property MktFeature[] $mktFeatures
 * @property MktPlan[] $mktPlans
 * @property MktPaymentGroup $paymentGroup
 */
class MktProduct extends \yii\db\ActiveRecord
{
    
    public function init() {
        parent::init();
        $this->isactive = true;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'required'],
            [['payment_group_id', 'isactive'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['payment_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktPaymentGroup::className(), 'targetAttribute' => ['payment_group_id' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'payment_group_id' => Yii::t('app', 'Payment Group'),
            'isactive' => Yii::t('app', 'Is active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktContracts()
    {
        return $this->hasMany(MktContract::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktFeatures()
    {
        return $this->hasMany(MktFeature::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktPlans()
    {
        return $this->hasMany(MktPlan::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentGroup()
    {
        return $this->hasOne(MktPaymentGroup::className(), ['id' => 'payment_group_id']);
    }
}
