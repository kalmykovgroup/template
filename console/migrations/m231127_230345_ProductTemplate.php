<?php

use yii\db\Migration;

/**
 * Class m231127_230345_ProductTemplate
 */
class m231127_230345_ProductTemplate extends Migration
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

        $this->createTable('product_template', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(), //Самое главное поле - для какой категории товаров
            'name' => $this->string()->notNull(), //Название шаблона
            'description' => $this->string()->notNull(), //Не большое описание шаблона
        ], $tableOptions);

        $this->addForeignKey('fk-product_template-category_id-category-id', 'product_template', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231127_230345_ProductTemplate cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231127_230345_ProductTemplate cannot be reverted.\n";

        return false;
    }
    */
}
