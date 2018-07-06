<?php

use yii\db\Migration;

/**
 * Class m180705_230535_product
 */
class m180705_230535_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('mkt_product', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'name' => $this->string(45)->notNull(),
            'payment_group_id' => $this->integer(),
            'isactive' => $this->boolean()->defaultValue(true),
                ], 'ENGINE=InnoDB');
                
        $this->createIndex('idx-product-payment_group_id', 'mkt_product', 'payment_group_id');                
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180705_230535_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180705_230535_product cannot be reverted.\n";

        return false;
    }
    */
}
