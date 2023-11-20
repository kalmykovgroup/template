<?php

use yii\db\Migration;

/**
 * Class m231120_161156_CartProduct
 */
class m231120_161156_CartProduct extends Migration
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

        $this->createTable('cart_product', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'cart_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_161156_CartProduct cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_161156_CartProduct cannot be reverted.\n";

        return false;
    }
    */
}
