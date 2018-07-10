<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_plan_has_feature".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property int $plan_id
 * @property int $feature_id
 * @property string $price
 * @property int $value
 * @property string $type
 *
 * @property MktFeature $feature
 * @property MktPlan $plan
 */
class MktPlanHasFeature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_plan_has_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['plan_id', 'feature_id', 'value'], 'integer'],
            [['price'], 'number'],
            [['type'], 'string'],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktFeature::className(), 'targetAttribute' => ['feature_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktPlan::className(), 'targetAttribute' => ['plan_id' => 'id']],
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
            'plan_id' => Yii::t('app', 'Plan ID'),
            'feature_id' => Yii::t('app', 'Feature ID'),
            'price' => Yii::t('app', 'Price'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(MktFeature::className(), ['id' => 'feature_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(MktPlan::className(), ['id' => 'plan_id']);
    }
}
