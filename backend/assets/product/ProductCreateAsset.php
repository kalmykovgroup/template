<?php

namespace backend\assets\product;

use yii\web\AssetBundle;

class ProductCreateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/product/create.css',
    ];
    public $js = [
        'js/product/create.js',
        'js/product/second_stage.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}