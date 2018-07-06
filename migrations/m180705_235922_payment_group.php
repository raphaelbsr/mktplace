<?php

use yii\db\Migration;

/**
 * Class m180705_235922_payment_group
 */
class m180705_235922_payment_group extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        $this->createTable('mkt_payment_group', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'name' => $this->string(45),
            'isactive' => $this->boolean()->defaultValue(true),
                ], 'ENGINE=InnoDB');
        
        $this->addForeignKey('fk-product-payment_group', 'mkt_product', 'payment_group_id', 'mkt_payment_group', 'id');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180705_235922_payment_group cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180705_235922_payment_group cannot be reverted.\n";

      return false;
      }
     */
}
