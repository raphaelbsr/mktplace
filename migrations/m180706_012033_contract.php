<?php

use yii\db\Migration;

/**
 * Class m180706_012033_contract
 */
class m180706_012033_contract extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->createTable('mkt_contract', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'product_key' => $this->string(64)->notNull(),
            'consumer_id' => $this->integer()->notNull(),
            'product_id' => $this->integer(),
            'payment_plan_id' => $this->integer(),
            'expire_at' => $this->date(),
                ], 'ENGINE=InnoDB');

        $this->createIndex('idx-contract-consumer_id', 'mkt_contract', 'consumer_id');
        $this->createIndex('idx-contract-product_id', 'mkt_contract', 'product_id');
        $this->createIndex('idx-contract-payment_plan_id', 'mkt_contract', 'payment_plan_id');

        $this->addForeignKey('fk-contract-consumer', 'mkt_contract', 'consumer_id', 'mkt_consumer', 'id');
        $this->addForeignKey('fk-contract-product', 'mkt_contract', 'product_id', 'mkt_product', 'id');
        $this->addForeignKey('fk-contract-payment_plan', 'mkt_contract', 'payment_plan_id', 'mkt_payment_plan', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180706_012033_contract cannot be reverted.\n";
        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180706_012033_contract cannot be reverted.\n";

      return false;
      }
     */
}
