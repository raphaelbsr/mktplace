<?php

use yii\db\Migration;

/**
 * Class m180705_212808_credit_cards
 */
class m180705_212808_credit_cards extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        $this->createTable('mkt_credit_card', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'number' => $this->string(64),
            'validthru' => $this->string(64),
            'name' => $this->string(64),
            'security_code' => $this->string(64),
            'consumer_id' => $this->integer()->notNull(),
            'consumer_cpf' => $this->string(11)->notNull(),
                ], 'ENGINE=InnoDB');
        
        $this->createIndex('idx-credit_card-consumer_id', 'mkt_credit_card', 'consumer_id');
        $this->createIndex('idx-credit_card-consumer_cpf', 'mkt_credit_card', 'consumer_cpf');
        
        $this->addForeignKey('fk-credid_card_consumer', 'mkt_credit_card', 'consumer_id', 'mkt_consumer', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-credid_card_consumer1', 'mkt_credit_card', 'consumer_cpf', 'mkt_consumer', 'cpf', 'CASCADE', 'CASCADE');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180705_212808_credit_cards cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180705_212808_credit_cards cannot be reverted.\n";

      return false;
      }
     */
}
