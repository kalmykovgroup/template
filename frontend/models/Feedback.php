<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property int $user_feedback_id
 * @property string|null $message
 * @property string $created_at
 *
 * @property UserFeedback $userFeedback
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_feedback_id'], 'required'],
            [['user_feedback_id'], 'integer'],
            [['created_at'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [['user_feedback_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserFeedback::class, 'targetAttribute' => ['user_feedback_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_feedback_id' => 'User Feedback ID',
            'message' => 'Message',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[UserFeedback]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFeedback()
    {
        return $this->hasOne(UserFeedback::class, ['id' => 'user_feedback_id']);
    }
}
