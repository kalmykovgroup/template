<?php

use yii\db\Migration;

/**
 * Class m231120_160758_Auth
 */
class m231120_160758_Auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(), //Ссылка на пользователя
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        //Связываем auth and User
        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_160758_Auth cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_160758_Auth cannot be reverted.\n";

        return false;
    }
    */
}
