<?php

namespace common\models;


/**
 * This is the model class for table "product_info".
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $manufacturer_barcode
 * @property string $barcode
 * @property int|null $brand_id
 * @property int $weight
 * @property int $width
 * @property int $height
 * @property int $length
 * @property int $count
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
    public static function tableName(): string
    {
        return 'product_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['count', 'barcode', 'weight', 'width', 'height', 'length'], 'required', 'message' => "Не может быть пустым"],
            [['product_id', 'count', 'brand_id','width', 'height', 'length'], 'integer'],
            ['weight' , 'double'],
            [['created_at', 'updated_at'], 'safe'],
            [['manufacturer_barcode', 'barcode', 'property_fields'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 6000],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            ['barcode', 'unique', 'message' => "Штрих-код уже занят, что-бы установить его на этом товаре, его нужно удалить на другом!"],
            ['manufacturer_barcode', 'unique', 'message' => "Штрих-код производителя уже установлен на другом товаре, что-бы установить его на этом товаре, его нужно удалить на другом!"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'manufacturer_barcode' => 'Штрих-код производителя',
            'barcode' => 'Штрих-код',
            'brand_id' => 'Выберите бренд',

            'count' => 'Кол-во на складе',
            'property_fields' => 'Property Fields',
            'short_description' => 'Короткое описание',

            'weight' => 'Вес кг.',
            'width' => 'Ширина см.',
            'height' => 'Высота см.',
            'length' => 'Длинна см.',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
