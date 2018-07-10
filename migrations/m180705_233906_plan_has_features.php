<?php

use yii\db\Migration;

/**
 * Class m180705_233906_plan_has_features
 */
class m180705_233906_plan_has_features extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('mkt_plan_has_feature', [
            'id' => $this->primaryKey(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'plan_id' => $this->integer(),
            'feature_id' => $this->integer(),
            'price' => $this->decimal(11, 2)->notNull()->defaultValue(0),
            'value' => $this->integer(),
            'type' => 'ENUM("BOOL","INTEGER")',
                ], 'ENGINE=InnoDB');

        $this->createIndex('idx-phf-plan_id', 'mkt_plan_has_feature', 'plan_id');
        $this->createIndex('idx-phf-feature_id', 'mkt_plan_has_feature', 'feature_id');

        $this->addForeignKey('fk-phf-plan', 'mkt_plan_has_feature', 'plan_id', 'mkt_plan', 'id');
        $this->addForeignKey('fk-phf-feature', 'mkt_plan_has_feature', 'feature_id', 'mkt_feature', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m180705_233906_plan_has_features cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180705_233906_plan_has_features cannot be reverted.\n";

      return false;
      }
     */
}
