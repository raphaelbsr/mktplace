<?php

use yii\db\Migration;

/**
 * Class m180705_235928_payment_plan
 */
class m180705_235928_payment_plan extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('mkt_payment_plan', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'discount_percentage' => $this->integer(),
            'name' => $this->string(45)->notNull(),
            'isactive' => $this->boolean()->defaultValue(true),
            'season' => $this->integer()->defaultValue(1),
            'payment_group_id' => $this->integer(),
                ], 'ENGINE=InnoDB');

        $this->createIndex('idx-mkt_payment_plan-pgid', 'mkt_payment_plan', 'payment_group_id');
        $this->addForeignKey('fk-payment_plan-paymento_group', 'mkt_payment_plan', 'payment_group_id', 'mkt_payment_group', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180705_235928_payment_plan cannot be reverted.\n";
        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180705_235928_payment_plan cannot be reverted.\n";

      return false;
      }
     */
}
