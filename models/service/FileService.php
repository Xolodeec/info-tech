<?php

namespace app\models\service;

use yii\web\UploadedFile;

class FileService
{
    public function uploadBookPhoto(UploadedFile $file): string
    {
        $path = '/uploads/books/' . uniqid() . '.' . $file->extension;
        $file->saveAs(\Yii::getAlias('@webroot') . $path);

        return $path;
    }
}