<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_consumer".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time 
 * @property string $token 
 *
 * @property MktBilling[] $mktBillings
 * @property MktBilling[] $mktBillings0
 * @property MktContract[] $mktContracts
 * @property MktContract[] $mktContracts0
 * @property MktCreditCard[] $mktCreditCards
 * @property MktCreditCard[] $mktCreditCards0
 */
class MktConsumer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_consumer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['token'], 'required'],
            [['token'], 'string', 'max' => 64],
            [['token'], 'unique'],
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
            'token' => Yii::t('app', 'Token'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktBillings()
    {
        return $this->hasMany(MktBilling::className(), ['consumer_id' => 'id']);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktContracts()
    {
        return $this->hasMany(MktContract::className(), ['consumer_id' => 'id']);
    }  

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMktCreditCards()
    {
        return $this->hasMany(MktCreditCard::className(), ['consumer_id' => 'id']);
    }        
    
}
