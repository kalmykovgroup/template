<?php

use yii\db\Migration;

/**
 * Class m231120_160827_Address
 */
class m231120_160827_Address extends Migration
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

        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(), //Ссылка на пользователя
            'street' => $this->integer()->notNull(), //Улица
            'house' => $this->string()->notNull(),      //Дом
            'apartment' => $this->string()->Null(),  //Квартира
            'entrance' => $this->string()->Null(),   //Подьезд
            'intercom' => $this->string()->Null(),   //Домофон
        ], $tableOptions);

        $this->addForeignKey('fk-address-user_id-user-id', 'address', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_160827_Address cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_160827_Address cannot be reverted.\n";

        return false;
    }
    */
}
