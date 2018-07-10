<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_feature".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property string $name
 * @property int $value
 * @property string $type
 * @property int $product_id
 *
 * @property MktProduct $product
 * @property MktPlanHasFeature[] $mktPlanHasFeatures
 */
class MktFeature extends \yii\db\ActiveRecord
{
    
    const BOOL = 'BOOL';
    const INTEGER = 'INTEGER';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['name', 'product_id'], 'required'],
            [['value', 'product_id'], 'integer'],
            [['type'], 'string'],
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
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
            'product_id' => Yii::t('app', 'Product ID'),
        ];
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
        return $this->hasMany(MktPlanHasFeature::className(), ['feature_id' => 'id']);
    }
}
