<?php

use yii\db\Migration;

/**
 * Class m231120_161038_Order
 */
class m231120_161038_Order extends Migration
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


        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(), //Ссылка на пользователя
            'address_id' => $this->integer()->Null(), //Ссылка на адресс доставки
            'comment_id' => $this->integer()->Null(), //Ссылка на коментарий к заказу
            'card_id' => $this->integer()->notNull(), //Ссылка на корзину
            'status' => $this->smallInteger()->Null()->defaultValue(10), //10 - Активный, удален, заблоктрован .
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),
        ], $tableOptions);
        //Связываем full_info and user
        $this->addForeignKey('fk-order-user_id-user-id', 'order', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-order-comment_id-comment-id', 'order', 'comment_id', 'comment', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_161038_Order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_161038_Order cannot be reverted.\n";

        return false;
    }
    */
}
