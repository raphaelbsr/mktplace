<?php

use yii\db\Migration;

/**
 * Class m180706_010219_pg_has_pp
 */
class m180706_010219_pg_has_pp extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        $this->createTable('mkt_pg_has_pp', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'payment_plan_id' => $this->integer(),
            'payment_group_id' => $this->integer(),
                ], 'ENGINE=InnoDB');
        
        $this->createIndex('idx-pg_has_pp-payment_group_id', 'pg_has_pp', 'payment_group_id');
        $this->addForeignKey('fk-pg_has_pp_plan-payment_group', 'pg_has_pp', 'payment_group_id', 'payment_group', 'id');
        $this->createIndex('idx-pg_has_pp-payment_plan_id', 'pg_has_pp', 'payment_plan_id');
        $this->addForeignKey('fk-pg_has_pp_plan-payment_plan', 'pg_has_pp', 'payment_plan_id', 'payment_plan', 'id');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180706_010219_pg_has_pp cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180706_010219_pg_has_pp cannot be reverted.\n";

      return false;
      }
     */
}
