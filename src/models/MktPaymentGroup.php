<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_payment_group".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property string $name
 * @property int $isactive
 * 
 * @property MktProduct[] $mktProducts
 * @property MktPaymentPlan[] $mktPaymentPlans
 */
class MktPaymentGroup extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_payment_group';
    }

    public function init() {        
        parent::init();
        $this->isactive = 1;
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['isactive'], 'integer'],
            [['name'], 'string', 'max' => 45],
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
            'isactive' => Yii::t('app', 'Is active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktPgHasPps()
    {
        return $this->hasMany(MktPgHasPp::className(), ['payment_group_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktPaymentPlans()
    {
        return $this->hasMany(MktPaymentPlan::className(), ['payment_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktProducts()
    {
        return $this->hasMany(MktProduct::className(), ['payment_group_id' => 'id']);
    }
}
