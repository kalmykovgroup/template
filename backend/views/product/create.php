<?php

/** @var yii\web\View $this */
/** @var common\models\Product $product */
/** @var common\models\Product $productInfo */
/** @var common\models\Category $category */
/** @var backend\models\UploadProductImg $uploadProductImg */
/** @var yii\web\View $this */

use backend\assets\product\ProductCreateAsset;
use common\models\Category;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

ProductCreateAsset::register($this);
?>


<div class="mainWrapper">
    <div class="main">
        <?php if(empty($product->id)):?>
            <h4>Новый товар</h4>
        <?php else: ?>
            <h4>ID: <?=$product->id?></h4>
        <?php endif; ?>

        <?php $form = ActiveForm::begin([
            'id' => 'form-create-product',
            'action' => empty($product->id) ? "/admin/product/create" : "/admin/product/update",
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",

                'options' => ['class' => 'field_block',],

                'horizontalCssClasses' => [
                    'label' => 'formFieldLabel',
                    'offset' => '',
                    'wrapper' => '',
                    'error' => '',
                    'hint' => '',
                ],
            ]
        ]); ?>


        <?= $form->field($productInfo, 'barcode')->textInput() ?>
        <?= $form->field($productInfo, 'manufacturer_barcode')->textInput() ?>

        <?= $form->field($product, 'name')->textInput() ?>

        <div class="groupBox groupBoxThree">
            <?= $form->field($product, 'price')->input("number", ['min' => 1])?>
            <?= $form->field($product, 'old_price', ['template' => "{label}\n<a href='#' class='plus_5'>+5%</a><a href='#' class='minus_5'>-5%</a>{input}\n{error}"])->input("number", ['min' => 1])?>
            <?= $form->field($product, 'start_price')->input("number", ['min' => 1]) ?>
            <?= $form->field($productInfo, 'count')->input("number", ['min' => 0]) ?>

        </div>

        <div class="groupBox groupBoxFour">
            <?= $form->field($product, 'unit', ['template' =>"
                 <select class='unit_of_measurement' id='unit-select'>
                   <option value='шт.'>шт.</option>
                    <option value='пач.'>пач.</option>
                     <option value='ед.'>ед.</option>
                      <option value='лист'>лист</option>
                     <option value='л.'>л.</option>
                      <option value='кг.'>кг.</option>
                 </select>
                 {label}\n{input}\n{error}
            
            "])->textInput(['value' => "шт."]) ?>
            <?= $form->field($productInfo, 'weight')->textInput() ?>
            <?= $form->field($productInfo, 'width')->textInput() ?>
            <?= $form->field($productInfo, 'height')->textInput() ?>
            <?= $form->field($productInfo, 'length')->textInput() ?>
        </div>


        <?php if(empty($product->id)): ?>
            <span style="display: none">
                 <?= $form->field($product, 'category_id')->input("number")->label(false)?>
            </span>

            <?= $form->field($product, 'search_category')->textInput(['placeholder' => 'Поиск']) ?>

            <div id="wrapperBlockSelectCategory">
                <div id="blockSelectCategory">

                        <?php $categories = $category::find()->orderBy(['id' => SORT_DESC])->all() ?>

                        <?php foreach($categories as $category): ?>

                            <a href="#" data-id="<?=$category->id?>" class="category"><?=$category->name ?></a>

                        <?php endforeach; ?>


                </div>
            </div>
        <?php else: ?>
            <div class="wrapperField">
                <div class="iconField">
                    <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 14.5V16.5M7 10.0288C7.47142 10 8.05259 10 8.8 10H15.2C15.9474 10 16.5286 10 17 10.0288M7 10.0288C6.41168 10.0647 5.99429 10.1455 5.63803 10.327C5.07354 10.6146 4.6146 11.0735 4.32698 11.638C4 12.2798 4 13.1198 4 14.8V16.2C4 17.8802 4 18.7202 4.32698 19.362C4.6146 19.9265 5.07354 20.3854 5.63803 20.673C6.27976 21 7.11984 21 8.8 21H15.2C16.8802 21 17.7202 21 18.362 20.673C18.9265 20.3854 19.3854 19.9265 19.673 19.362C20 18.7202 20 17.8802 20 16.2V14.8C20 13.1198 20 12.2798 19.673 11.638C19.3854 11.0735 18.9265 10.6146 18.362 10.327C18.0057 10.1455 17.5883 10.0647 17 10.0288M7 10.0288V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V10.0288" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <?= $form->field($category, 'name')->textInput(['disabled' => true])->label("Категория")?>
            </div>


        <?php endif; ?>


            <div class="commonMessage" id="commonMessageFirstStage"></div>

            <div class="blockBtn">
                   <?= Html::submitButton(empty($product->id) ? 'Создать новый продукт' : 'Сохранить изменения', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>

        <style>
            .blockUploadImg{
                width: 100%;

                padding: 5px;
            }

            #gridImg{
                width: 100%;
                min-height: 100px;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
            }

            .blockSelect{
                width: 100%;
                height: 100px;
                border: 1px dashed #808080;
                border-radius: 5px;
                margin-top: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .field-uploadproductimg-imagefiles{
                position: relative;
            }

            .field-uploadproductimg-imagefiles .invalid-feedback{
                position: absolute;
            }

            .blockUploadImg .itemImg{
                margin: 5px;
                width: 110px;
                height: 130px;
                border: 1px solid #bdbdbd;
                border-radius: 5px;
                position: relative;
                display: flex;
                align-items: center;

            }
            .blockUploadImg .itemImg img{
                max-width: 100%;
                max-height: 100%;
                background-size: contain;
            }
            .blockUploadImg .itemImg .delete_picture_box{
                position: absolute;
                width: 20px;
                height: 20px;
                border: 1px solid #818181;
                border-radius: 5px;
                display: flex;
                line-height: 5px;
                color: #1e1e1e;
                justify-content: center;
                align-items: center;
                top: -5px;
                right: -5px;
                background: white;
                padding-bottom: 3px;
                z-index: 2;
                font: -apple-system-short-footnote;
            }

            .blockUploadImg .itemImg .delete_picture_box:hover{

                color: #0d6efd;
                border: 1px solid #0d6efd;
                font-weight: 500;
            }

            .itemImg .blackout{
                position: absolute;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.25);
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .itemImg .progress{
                color: #007531;
                z-index: 2;
                padding: 3px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .curtainDeleted{
                position: absolute;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.2);
                color: white;
                font-size: 20px;
                font-weight: 500;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .main_img{
                box-shadow: 0 0 10px red;
            }
        </style>

        <?php if(!empty($product->id)):?>

            <div class="blockUploadImg">

                <div id="gridImg" data-id="<?=$product->id?>">

                    <?php  $path =  __DIR__ . '/../../../frontend/web/img/upload/product/'. $product->id . '/'; ?>

                    <?php if(is_dir($path)): ?>

                        <?php $files = FileHelper::findFiles($path); ?>

                        <?php foreach($files as $key => $file): ?>

                            <?php $class_ = ""; if ($key === array_key_first($files)) { $class_ = "main_img"; } ?>

                            <div class='itemImg uploaded_picture_box <?=$class_?>'>

                                <?= Html::img('/frontend/web/img/upload/product/'. $product->id . '/' . basename($file)) ?>

                                <a href='#' data-id='<?=$product->id?>' data-filename="<?=basename($file)?>" class='delete_picture_box'>x</a>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
                <div class="blockSelect">

                    <?php $form = ActiveForm::begin([
                            'id' => 'form-upload-img',
                            'action' => "/admin/product/upload-img?id=" . $product->id,
                            'options' => ['enctype' => 'multipart/form-data']]) ?>

                    <?= $form->field($uploadProductImg, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label(false) ?>

                    <span style="display: none">
                          <?= Html::submitButton('Отправить', ['id' => 'btn_send_form_upload_img']) ?>
                    </span>


                    <?php ActiveForm::end() ?>

                </div>

            </div>
        <?php endif; ?>

    </div>
