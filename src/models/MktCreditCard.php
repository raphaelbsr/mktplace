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
class MktCreditCard extends \yii\db\ActiveRecord {

    public $month;
    public $year;

    const MONTH = [1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        11 => 11,
        12 => 12,
    ];

    public static $YEAR = [];

    public function init() {
        parent::init();

        $this->number = "123456789123456789";
        $this->name = "KURT B S COBAIN";
        $this->month = 2;
        $this->year = 2019;        
        $this->security_code = 456;
        
        $curYeah = date('Y');
        for ($i = 0; $i < 10; $i++) {
            $nYear = $curYeah + $i;
            self::$YEAR[$nYear] = $nYear;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mkt_credit_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['create_time', 'update_time', 'isdefault', 'month', 'year'], 'safe'],
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
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'number' => Yii::t('app', 'Card Number'),
            'validthru' => Yii::t('app', 'Valid Thru'),
            'name' => Yii::t('app', 'Name'),
            'security_code' => Yii::t('app', 'Code'),
            'consumer_id' => Yii::t('app', 'Consumer'),
            'isdefault' => Yii::t('app', 'Is Default'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsumer() {
        return $this->hasOne(MktConsumer::className(), ['id' => 'consumer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsumerCpf() {
        return $this->hasOne(MktConsumer::className(), ['cpf' => 'consumer_cpf']);
    }

}
