<?php

use yii\db\Migration;

/**
 * Class m231120_160943_ProductInfo
 */
class m231120_160943_ProductInfo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_info', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),

            'manufacturer_barcode' => $this->string()->Null(),  //Код товара, который ему присваивает производитель. Если кодов несколько, укажите их через запятую.
            'barcode' => $this->string()->notNull(),
            'brand_id' => $this->integer()->Null(),

            'property_fields' => $this->string()->Null(),//

            'short_description' => $this->string(6000)->Null(), //Описание товара, до 6 000 символов
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),//дата добавления
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),//дата последнего обновления

        ]);

        $this->addForeignKey('fk-product_info-product_id-product-id', 'product_info', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_160943_ProductInfo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_160943_ProductInfo cannot be reverted.\n";

        return false;
    }
    */
}
