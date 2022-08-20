<?php

namespace app\components;

use app\modules\admin\models\Images;
use app\modules\admin\models\Imgforcomments;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageLoaderComponent
{
    public function saveUploadedImage(UploadedFile $file): string
    {
        $path = $this->genPathForFile($file);
        return $file->saveAs($path) ? $path : '';
    }

    private function genPathForFile(UploadedFile $file): string
    {
        FileHelper::createDirectory(\Yii::getAlias('@webroot/images/'));
        return \Yii::getAlias('@webroot/images/') . uniqid() . '.' . $file->extension;
    }

    public function loadImages($model): bool
    {
        foreach ($model->image as &$image) {
            if ($file = $this->saveUploadedImage($image)) {
                $image = basename($file);
            }
        }
        return true;
    }

    public function saveImages($images, $id, $const)
    {
        if ($const === 'Images') {
            foreach ($images as $name) {
                $imageModel = new Images();
                $imageModel->feedback_id = $id;
                $imageModel->name = $name;
                $imageModel->save();
            }
        }

        if ($const === 'IMG') {
            foreach ($images as $name) {
                $imageModel = new Imgforcomments();
                $imageModel->comment_id = $id;
                $imageModel->name = $name;
                $imageModel->save();
            }
        }
    }
}