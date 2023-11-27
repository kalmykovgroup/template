<?php

namespace app\models;

use common\models\Product;

/**
 * This is the model class for table "user_feedback".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property int $value
 * @property string|null $message
 * @property int|null $photo
 *
 * @property Feedback[] $feedbacks
 * @property Product $product
 */
class UserFeedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'value'], 'required'],
            [['product_id', 'user_id', 'value', 'photo'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'value' => 'Value',
            'message' => 'Message',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['user_feedback_id' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
