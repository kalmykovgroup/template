<?php

use yii\db\Migration;

/**
 * Class m231128_003547_ProductTemplate_Specifications
 */
class m231128_003547_ProductTemplate_Specifications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('product_template_specification', [
            'id' => $this->primaryKey(),
            'product_template_id' => $this->integer()->notNull(),
            'specification_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk-product_template_specification-product_template_id-product_template-id', 'product_template_specification', 'product_template_id', 'product_template', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-product_template_specification-specification_id-specification-id', 'product_template_specification', 'specification_id', 'specification', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231128_003547_ProductTemplate_Specifications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231128_003547_ProductTemplate_Specifications cannot be reverted.\n";

        return false;
    }
    */
}
