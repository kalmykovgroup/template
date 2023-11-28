<?php

use yii\db\Migration;

/**
 * Class m231128_003504_Specifications
 */
class m231128_003504_Specifications extends Migration
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

        $this->createTable('specification', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(), //Самое главное поле - для какой категории товаров
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231128_003504_Specifications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231128_003504_Specifications cannot be reverted.\n";

        return false;
    }
    */
}
