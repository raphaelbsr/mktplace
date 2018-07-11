<?php

namespace raphaelbsr\mktplace\models;

use Yii;

/**
 * This is the model class for table "mkt_credit_card".
 *
 * @property int $id
 * @property string $create_time
 * @property string $update_time
 * @property string $number
 * @property string $validthru
 * @property string $name
 * @property string $security_code
 * @property int $consumer_id
 * @property string $consumer_cpf
 * @property boolean $isdefault
 *
 * @property MktConsumer $consumer
 */
class MktCreditCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mkt_credit_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time', 'isdefault'], 'safe'],
            [['consumer_id', 'consumer_cpf'], 'required'],
            [['consumer_id'], 'integer'],
            [['number', 'validthru', 'name', 'security_code'], 'string', 'max' => 64],
            [['consumer_cpf'], 'string', 'max' => 11],
            [['consumer_id'], 'exist', 'skipOnError' => true, 'targetClass' => MktConsumer::className(), 'targetAttribute' => ['consumer_id' => 'id']],
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
            'number' => Yii::t('app', 'Card Number'),
            'validthru' => Yii::t('app', 'Valid Thru'),
            'name' => Yii::t('app', 'Name'),
            'security_code' => Yii::t('app', 'Security Code'),
            'consumer_id' => Yii::t('app', 'Consumer'),
            'isdefault' => Yii::t('app', 'Is Default'),
        ];
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
    public function getConsumerCpf()
    {
        return $this->hasOne(MktConsumer::className(), ['cpf' => 'consumer_cpf']);
    }
}
