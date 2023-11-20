<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_info".
 *
 * @property int $id
 * @property int $category_id
 * @property int $product_id
 * @property string|null $manufacturer_barcode
 * @property string $barcode
 * @property int|null $brand_id
 * @property string|null $property_fields
 * @property string|null $short_description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 */
class ProductInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'product_id', 'barcode'], 'required'],
            [['category_id', 'product_id', 'brand_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['manufacturer_barcode', 'barcode', 'property_fields'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 6000],
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
            'category_id' => 'Category ID',
            'product_id' => 'Product ID',
            'manufacturer_barcode' => 'Manufacturer Barcode',
            'barcode' => 'Barcode',
            'brand_id' => 'Brand ID',
            'property_fields' => 'Property Fields',
            'short_description' => 'Short Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
