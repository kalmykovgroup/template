<?php

use yii\db\Migration;

/**
 * Class m231120_160854_Product
 */
class m231120_160854_Product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string()->Null(),//Название товара
            'status' => $this->integer()->Null(),//Статус товара
            'unit' => $this->string()->notNull(), //Единица измерения
            'price' =>$this->string()->notNull(), //Текущая цена
            'old_price' =>$this->string()->Null(), //Старая цена
            'start_price' =>$this->string()->notNull(),//Цена закупки

            'rating' => $this->integer()->notNull()->defaultValue(0), //рейтинг, перерасчет всех отзывов

        ]);
        $this->addForeignKey('fk-product-category_id-category-id', 'product', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_160854_Product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_160854_Product cannot be reverted.\n";

        return false;
    }
    */
}
