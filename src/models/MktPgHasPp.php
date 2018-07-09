<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_pg_has_pp".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property int $payment_plan_id
 * @property int $payment_group_id
 *
 * @property MktPaymentGroup $paymentGroup
 * @property MktPaymentPlan $paymentPlan
 */
class MktPgHasPp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_pg_has_pp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['payment_plan_id', 'payment_group_id'], 'integer'],
            [['payment_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktPaymentGroup::className(), 'targetAttribute' => ['payment_group_id' => 'id']],
            [['payment_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktPaymentPlan::className(), 'targetAttribute' => ['payment_plan_id' => 'id']],
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
            'payment_plan_id' => Yii::t('app', 'Payment Plan ID'),
            'payment_group_id' => Yii::t('app', 'Payment Group ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentGroup()
    {
        return $this->hasOne(MktPaymentGroup::className(), ['id' => 'payment_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentPlan()
    {
        return $this->hasOne(MktPaymentPlan::className(), ['id' => 'payment_plan_id']);
    }
}
