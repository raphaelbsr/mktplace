<?php

use yii\db\Migration;

/**
 * Class m180706_014059_billing
 */
class m180706_014059_billing extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->createTable('mkt_billing', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'consumer_id' => $this->integer()->notNull(),
            'contract_id' => $this->integer(),
            'payment_date' => $this->dateTime()->defaultValue(null),
            'amount' => $this->decimal(11, 2),
            'due_date' => $this->date(),
            'paymentid' => $this->string(64),
            'status' => "enum('CREATED','SENT','PAID','CANCELED') NOT NULL DEFAULT 'CREATED'",
                ], 'ENGINE=InnoDB');

        $this->createIndex('idx-billing-consumer_id', 'mkt_billing', 'consumer_id');
        $this->createIndex('idx-billing-contract_id', 'mkt_billing', 'contract_id');

        $this->addForeignKey('fk-billing-consumer', 'mkt_billing', 'consumer_id', 'mkt_consumer', 'id');
        $this->addForeignKey('fk-billing-contract', 'mkt_billing', 'contract_id', 'mkt_contract', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180706_014059_billing cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180706_014059_billing cannot be reverted.\n";

      return false;
      }
     */
}
