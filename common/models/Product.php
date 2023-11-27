<?php

namespace common\models;

use app\models\UserFeedback;
use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $name
 * @property int|null $status
 * @property string $unit
 * @property string $price
 * @property string|null $old_price
 * @property string $start_price
 * @property int $rating
 *
 * @property Category $category
 * @property ProductInfo[] $productInfo
 * @property UserFeedback[] $userFeedback
 *
 * @property string $search_category
 */
class Product extends \yii\db\ActiveRecord
{

    public $search_category;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['search_category', 'category_id', 'unit', 'price', 'start_price', 'name'], 'required', 'message' => "Не может быть пустым"],
            [['category_id', 'status', 'rating', 'id'], 'integer'],
            [['name', 'unit', 'price', 'old_price', 'start_price'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['name'], 'unique', 'message' => "Товар с таким названием уже существует"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'search_category' => 'Категория',
            'name' => 'Название',
            'unit' => 'Ед.из.',
            'price' => 'Розничная цена',
            'old_price' => 'Зачеркнутая цена',
            'start_price' => 'Закупочная цена',
        ];
    }


    /**
     * @throws Exception
     */
    public function create($productInfo): bool
    {
        if(!$this->validate() || !$productInfo->validate()){
            return false;
        }

        $transaction = $this->getDb()->beginTransaction();
        try{
            if($this->save()){
                $productInfo->product_id = $this->id;
                if($productInfo->save()){
                    $transaction->commit();
                    return true;
                }
            }
        }catch (\yii\db\Exception $e){
             $transaction->rollBack(); //Отменили транзакцию
             Yii::error($e, 'app'); //Записали лог об ошибке
                 $this->addError("common", "Ошибка при добавлении в базу данных");
        }
        return false;
    }


    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ProductInfos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductInfo(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ProductInfo::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[UserFeedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFeedback(): \yii\db\ActiveQuery
    {
        return $this->hasMany(UserFeedback::class, ['product_id' => 'id']);
    }
}
