<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_plan".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property string $name
 * @property string $description
 * @property string $price
 * @property int $product_id
 *
 * @property MktContract[] $mktContracts
 * @property MktProduct $product
 * @property MktPlanHasFeature[] $mktPlanHasFeatures
 */
class MktPlan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['name', 'description', 'product_id'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['product_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
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
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'product_id' => Yii::t('app', 'Product ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktContracts()
    {
        return $this->hasMany(MktContract::className(), ['plan_id' => 'id']);
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
    public function getMktPlanHasFeatures()
    {
        return $this->hasMany(MktPlanHasFeature::className(), ['plan_id' => 'id']);
    }
}
