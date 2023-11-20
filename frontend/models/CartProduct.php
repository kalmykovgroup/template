<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cart_product".
 *
 * @property int $id
 * @property int $product_id
 * @property int $cart_id
 * @property int $qty
 */
class CartProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'cart_id', 'qty'], 'required'],
            [['product_id', 'cart_id', 'qty'], 'integer'],
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
            'cart_id' => 'Cart ID',
            'qty' => 'Qty',
        ];
    }
}
