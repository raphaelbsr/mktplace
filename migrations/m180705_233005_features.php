<?php

use yii\db\Migration;

/**
 * Class m180705_233005_features
 */
class m180705_233005_features extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        $this->createTable('mkt_feature', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'name' => $this->string(45)->notNull(),
            'value' => $this->integer(),
            'type' => 'ENUM("BOOL","INTEGER")',
            'product_id' => $this->integer()->notNull(),
                ], 'ENGINE=InnoDB');
        
        $this->createIndex('idx-feature-product_id', 'feature', 'product_id');
        $this->addForeignKey('fk-feature-product', 'feature', 'product_id', 'product', 'id');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180705_233005_features cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180705_233005_features cannot be reverted.\n";

      return false;
      }
     */
}
