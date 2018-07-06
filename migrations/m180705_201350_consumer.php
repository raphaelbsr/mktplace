<?php

use yii\db\Migration;

/**
 * Class m180705_201350_consumer
 */
class m180705_201350_consumer extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->createTable('mkt_consumer', [
            'id' => $this->primaryKey(),            
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
//            'username' => $this->string(32)->notNull()->unique(),
//            'useremail' => $this->string(100)->notNull()->unique(),
//            'password' => $this->string(64)->notNull(),
//            'password_token' => $this->string(64)->defaultValue(null),
            'cpf' => $this->string(11)->notNull()->unique(),
//            'name' => $this->string(45)->notNull(),
//            'last_name' => $this->string(45)->notNull(),
//            'phone' => $this->string(10),
//            'celphone' => $this->string(11),
//            'company' => $this->string(45),
//            'company_cnpj' => $this->string(14)
                ], 'ENGINE=InnoDB');

        $this->createIndex('idx-consumer-cpf', 'mkt_consumer', 'cpf');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180705_201350_user cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180705_201350_user cannot be reverted.\n";

      return false;
      }
     */
}
