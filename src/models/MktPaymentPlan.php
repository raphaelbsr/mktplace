<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_payment_plan".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property int $discount_percentage
 * @property int $isactive
 * @property int $season
 * @property string $name
 *
 * @property MktContract[] $mktContracts 
 * @property MktPaymentGroup $mktPaymentGroup
 */
class MktPaymentPlan extends \yii\db\ActiveRecord
{
    
    public function init() {
        parent::init();
        $this->isactive = 1;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_payment_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['discount_percentage', 'isactive', 'season', 'payment_group_id'], 'integer'],
            [['name'], 'string'],
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
            'discount_percentage' => Yii::t('app', 'Discount'),
            'isactive' => Yii::t('app', 'Isactive'),
            'season' => Yii::t('app', 'Seasons'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktContracts()
    {
        return $this->hasMany(MktContract::className(), ['payment_plan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktPaymentGroup()
    {
        return $this->hasMany(MktPgHasPp::className(), ['payment_plan_id' => 'id']);
    }
}
