<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;
class UploadProductImg extends Model
{

    /**
     * @var UploadedFile
     */
    public $imageFiles;

    public function rules(): array
    {
        return [
           ['imageFiles', 'image',
                'extensions' => ['jpg', 'jpeg', 'png'],
                'maxFiles' => 10,
                'checkExtensionByMimeType' => true,
                'maxSize' => 512000, // 500 килобайт = 500 * 1024 байта = 512 000 байт
                'tooBig' => 'Limit is 500KB',
               'skipOnEmpty' => true,
            ],
        ];
    }

    public function deleteImg($id, $filename): bool{
       return unlink(__DIR__ . "/../../frontend/web/img/upload/product/$id/$filename");
    }


    public function upload($id, &$filename = null): bool
    {
        if ($this->validate()) {
            $path = __DIR__ . "/../../frontend/web/img/upload/product/$id/";

            if (!is_dir( $path))  mkdir($path, 0777, true);


            if(count(array_diff(scandir( "$path"), array('..', '.'))) >= 10){
                $this->addError("imageFiles", "Максимум 10 фото");
                return false;
            }
            $file = $this->imageFiles[0];
            $filename = time();
            for(; ;){
                if(!file_exists($path . ++$filename . ".$file->extension")){
                    return $file->saveAs($path . $filename . ".$file->extension");
                }
            }


        }
        return false;

    }
}