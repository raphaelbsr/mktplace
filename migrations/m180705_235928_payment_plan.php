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
            'season' => $this->integer()->defaultValue(1)
                ], 'ENGINE=InnoDB');        
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
