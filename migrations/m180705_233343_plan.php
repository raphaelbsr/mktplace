<?php

use yii\db\Migration;

/**
 * Class m180705_233343_plan
 */
class m180705_233343_plan extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('mkt_plan', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'name' => $this->string(45)->notNull(),
            'description' => $this->text()->notNull(),
            'price' => $this->decimal(11,2)->notNull()->defaultValue(0),
            'product_id' => $this->integer()->notNull(),
                ], 'ENGINE=InnoDB');
        
        $this->createIndex('idx-plan-product_id', 'plan', 'product_id');
        $this->addForeignKey('fk-plan-product', 'plan', 'product_id', 'product', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180705_233343_plan cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180705_233343_plan cannot be reverted.\n";

      return false;
      }
     */
}
