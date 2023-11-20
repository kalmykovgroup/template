<?php

use yii\db\Migration;

/**
 * Class m231120_161023_Feedback
 */
class m231120_161023_Feedback extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('feedback', [ //Ответы админов на отзывы
            'id' => $this->primaryKey(),
            'user_feedback_id' => $this->integer()->notNull(),
            'message' => $this->string(255)->Null(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
        ]);

        $this->addForeignKey('fk-feedback-user_feedback_id-user_feedback-id', 'feedback', 'user_feedback_id', 'user_feedback', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231120_161023_Feedback cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231120_161023_Feedback cannot be reverted.\n";

        return false;
    }
    */
}
