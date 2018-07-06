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
            'consumer_cpf' => $this->string(14)->notNull(),
            'product_id' => $this->integer(),
            'payment_plan_id' => $this->integer(),
            'expire_at' => $this->date(),
                ], 'ENGINE=InnoDB');

        $this->createIndex('idx-contract-consumer_id', 'contract', 'consumer_id');
        $this->createIndex('idx-contract-consumer_cpf', 'contract', 'consumer_cpf');
        $this->createIndex('idx-contract-product_id', 'contract', 'product_id');
        $this->createIndex('idx-contract-payment_plan_id', 'contract', 'payment_plan_id');

        $this->addForeignKey('fk-contract-consumer', 'contract', 'consumer_id', 'consumer', 'id');
        $this->addForeignKey('fk-contract-consumer1', 'contract', 'consumer_cpf', 'consumer', 'cpf');
        $this->addForeignKey('fk-contract-product', 'contract', 'product_id', 'product', 'id');
        $this->addForeignKey('fk-contract-payment_plan', 'contract', 'payment_plan_id', 'payment_plan', 'id');
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
