<?php

namespace backend\controllers;

use backend\models\UploadProductImg;
use common\models\Category;
use common\models\Product;
use common\models\ProductInfo;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'create', 'update',  'upload-img', 'delete-img'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }



    public function actionUploadImg($id): false|string
    {
        try{
            if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {

                $uploadProductImg = new UploadProductImg();

                if(!Product::find()->where(['id' => $id])->exists()){
                    $uploadProductImg->addError("Продукт с Id: " . $id . " не найден.");
                }

                 $uploadProductImg->imageFiles = UploadedFile::getInstances($uploadProductImg, 'imageFiles');


                if ($uploadProductImg->upload($id, $fileName)) {
                    return json_encode(['result' => 'success', 'filename' => $fileName]);
                }else{
                    return json_encode(['result' => 'error', "errors" => $uploadProductImg->errors]);
                }


            }
        }catch(\Exception $e){
            return json_encode(['result' => 'error', ["common" => [$e->getMessage()]]]);
        }
        return false;
    }

    public function actionDeleteImg(): false|string
    {
        try {
            if (Yii::$app->request->isAjax) {

                $uploadProductImg = new UploadProductImg();

                if($uploadProductImg->deleteImg(Yii::$app->request->post('id'), Yii::$app->request->post('filename'))){
                    return json_encode(['result' => 'success']);
                }

                $uploadProductImg->addError("Произошла ошибка во время удаления файла");

                return json_encode(['result' => 'error', "errors" => $uploadProductImg->errors]);
            }
        }
        catch(\Exception $e){
            return json_encode(['result' => 'error', "errors" => ["common" => [$e->getMessage()]]]);
        }
        return false;
    }

    /**
     */
    public function actionCreate(): string
    {

        $product = new Product();
        $productInfo = new ProductInfo();
        $category = new Category();
        $uploadProductImg = new UploadProductImg();

        if(Yii::$app->request->isAjax){
            try{
                if($product->load(Yii::$app->request->post()) && $productInfo->load(Yii::$app->request->post())){

                    if($product->create($productInfo)){
                        return json_encode(['result' => 'success', 'id' => $product->id]);
                    }else{
                        return json_encode(['result' =>'error', "errors" => array_merge($product->errors, $productInfo->errors)]);
                    }
                }
                $product->addError("common", "Ошибка загрузки данных");
                return json_encode(['result' => 'error', "errors" => array_merge($product->errors, $productInfo->errors)]);

            }catch(\Exception $e){
                return json_encode(['result' => 'error', "errors" =>  [$e->getMessage()]]);
            }

        }

        $product->name = "Тестовый товар";
        $product->search_category = "Инструменты";
        $product->category_id = 1;
        $product->unit = 1;
        $product->price = 1000;
        $product->old_price = 1500;
        $product->start_price = 400;

        $productInfo->count = 100;
        $productInfo->barcode = 12345;
        $productInfo->weight = 3;
        $productInfo->width = 4;
        $productInfo->height = 5;
        $productInfo->length = 6;
        $productInfo->manufacturer_barcode = 12345;
        $productInfo->short_description = "Короткое описание";

        return $this->render('create', compact('product', 'productInfo', 'category', 'uploadProductImg'));
    }

    public function actionUpdate($id): bool|string
    {
        $product = Product::findOne(['id' => $id]);

        if(!empty($product)){
            $productInfo = ProductInfo::findOne(['product_id' => $id]);
            $category = Category::findOne(['id' => $product->category_id]);

            $uploadProductImg = new UploadProductImg();

            if(Yii::$app->request->isAjax){
                if($product->load(Yii::$app->request->post()) && $productInfo->load(Yii::$app->request->post())) {
                    return true;
                }
                return false;
            }

            return $this->render('create', compact('product', 'productInfo', 'category', 'uploadProductImg'));
        }
        return throw new InvalidArgumentException("Продукт с id: " . $id . " не найден");
    }


}