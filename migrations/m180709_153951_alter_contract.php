<?php

use yii\db\Migration;

/**
 * Class m180709_153951_alter_contract
 */
class m180709_153951_alter_contract extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('mkt_contract', 'plan_id', $this->integer());
        $this->createIndex('idx-contract-plan_id', 'mkt_contract', 'plan_id');
        $this->addForeignKey('fk-contract-plan', 'mkt_contract', 'plan_id', 'mkt_plan', 'id', 'SET NULL' , 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180709_153951_alter_contract cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180709_153951_alter_contract cannot be reverted.\n";

        return false;
    }
    */
}