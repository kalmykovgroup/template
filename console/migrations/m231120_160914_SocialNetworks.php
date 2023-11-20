<?php

use yii\db\Migration;

/**
 * Class m231120_160914_SocialNetworks
 */
class m231120_160914_SocialNetworks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Таблица где храняться данные о соц сети для авторизации, нужно только для разработчиков
        $this->createTable('{{%social_networks}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'clientId' => $this->string()->Null(),
            'clientSecret' => $this->string()->Null(),
            'username' => $this->string()->Null(), //Аккаунт в соц-сети на который сделана авторизация
            'password' => $this->string()->Null(),
            'src' => $this->string()->Null(), //Путь к соц-сети
            'status' => "ENUM('0', '1')  NOT NULL DEFAULT '0'", //Статус рабочего состояния
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'), //Дата обновления
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_160914_SocialNetworks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_160914_SocialNetworks cannot be reverted.\n";

        return false;
    }
    */
}
