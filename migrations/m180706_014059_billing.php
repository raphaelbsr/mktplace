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
            'consumer_cpf' => $this->string(14)->notNull(),
            'contract_id' => $this->integer(),
            'payment_date' => $this->dateTime()->defaultValue(null),
            'amount' => $this->decimal(11, 2),
            'due_date' => $this->date(),
                ], 'ENGINE=InnoDB');

        $this->createIndex('idx-billing-consumer_id', 'billing', 'consumer_id');
        $this->createIndex('idx-billing-consumer_cpf', 'billing', 'consumer_cpf');
        $this->createIndex('idx-billing-contract_id', 'billing', 'contract_id');

        $this->addForeignKey('fk-billing-consumer', 'billing', 'consumer_id', 'consumer', 'id');
        $this->addForeignKey('fk-billing-consumer1', 'billing', 'consumer_cpf', 'consumer', 'cpf');
        $this->addForeignKey('fk-billing-contract', 'billing', 'contract_id', 'contract', 'id');
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
