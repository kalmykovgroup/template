<?php

use yii\db\Migration;

/**
 * Class m231120_160616_UserInfo
 */
class m231120_160616_UserInfo extends Migration
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


        $this->createTable('{{%user_info}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(), //Ссылка на пользователя
            'last_name' => $this->string(255)->Null(), //Фамилия
            'patronymic' => $this->string(255)->Null(), //Отчество
            'date_of_birth' => $this->date()->Null(), //Дата рождения
            'gender' => "ENUM('female', 'male')", // female - женский.
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE NOW()'),
        ], $tableOptions);
        //Связываем full_info and user
        $this->addForeignKey('fk-user_info-user_id-user-id', 'user_info', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_160616_UserInfo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_160616_UserInfo cannot be reverted.\n";

        return false;
    }
    */
}
