<?php

use yii\db\Migration;

/**
 * Class m231120_161003_UserFeedback
 */
class m231120_161003_UserFeedback extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_feedback', [ //Отзыв
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(), //Какому товару
            'user_id' => $this->integer()->notNull(), //Кто поставил
            'value' => $this->integer()->notNull(), //Кол-во поставленных звездочек
            'message' => $this->string(255)->Null(), //Текст отзыва, если он есть
            'photo' => $this->boolean(), //Наличие фото к отзыву
        ]);

        $this->addForeignKey('fk-user_feedback-product_id-product-id', 'user_feedback', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_161003_UserFeedback cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_161003_UserFeedback cannot be reverted.\n";

        return false;
    }
    */
}
