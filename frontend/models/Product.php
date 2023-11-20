<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $name
 * @property int|null $status
 * @property string $unit
 * @property int $count
 * @property string $price
 * @property string|null $old_price
 * @property string $start_price
 * @property int $rating
 *
 * @property Category $category
 * @property ProductInfo[] $productInfos
 * @property UserFeedback[] $userFeedbacks
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'unit', 'count', 'price', 'start_price'], 'required'],
            [['category_id', 'status', 'count', 'rating'], 'integer'],
            [['name', 'unit', 'price', 'old_price', 'start_price'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'status' => 'Status',
            'unit' => 'Unit',
            'count' => 'Count',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'start_price' => 'Start Price',
            'rating' => 'Rating',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ProductInfos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductInfos()
    {
        return $this->hasMany(ProductInfo::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[UserFeedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFeedbacks()
    {
        return $this->hasMany(UserFeedback::class, ['product_id' => 'id']);
    }
}
