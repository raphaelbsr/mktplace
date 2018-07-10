<?php

namespace raphaelbsr\mktplace\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;

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
class MktProduct extends ActiveRecord {

    public function init() {
        parent::init();
        $this->isactive = true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mkt_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
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
    public function attributeLabels() {
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
     * @return ActiveQuery
     */
    public function getMktContracts() {
        return $this->hasMany(MktContract::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMktFeatures() {
        return $this->hasMany(MktFeature::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMktPlans() {
        return $this->hasMany(MktPlan::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPaymentGroup() {
        return $this->hasOne(MktPaymentGroup::className(), ['id' => 'payment_group_id']);
    }

    public function plansAsColums() {

        $plans = $this->mktPlans;
        $colums = [];
        $colums[] = [
            'label' => 'Feats/Plans',
            'value' => 'name',
        ];
        foreach ($plans as $plan) {
            $colums[] = [
                'label' => $plan->name,
                'format' => 'raw',
                'value' => function(MktFeature $model) use ($plan) {
                    $featureHasPlan = MktPlanHasFeature::find()->where(['plan_id' => $plan->id, 'feature_id' => $model->id])->one();
                    $id = $model->id . '-' . $plan->id;
                    $name = 'PlanHasFeature[' . $id . '][value]';
                    $nameHidden = 'PlanHasFeature[' . $id . '][hidden]';                    
                    $hiddenInput =  Html::hiddenInput($nameHidden);
                    if ($featureHasPlan) {
                        //$options = ['class' => 'form-control'];
                        //return 'has';
                    } else {
                        $options = [];
                        //return 'has not';
                    }
                    switch ($model->type) {
                        case MktFeature::INTEGER:
//                            return Html::textInput( 'PlanHasFeature['. $index.'][phf]',null,$options);
                            return Html::textInput($name, null, $options). $hiddenInput;
                        case MktFeature::BOOL:
                            //return Html::checkbox($name, null, null) .  Html::hiddenInput($name, 0) . $hiddenInput;
                    }
                },
                'contentOptions' => ['class' => 'text-center']
            ];
        }
        return $colums;
    }

}
