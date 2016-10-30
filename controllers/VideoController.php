<?php

namespace app\controllers;

use app\models\Video;
use Yii;
use app\models\UploadForm;
use app\models\Source;
use yii\web\UploadedFile;

class VideoController extends \yii\web\Controller
{

    public function actionIndex($id = 0)
    {

        $video = Video::fetchOne($id);
        if (!isset($video->videoUrl) || !isset($video->videoUrl[0]) || !$video->videoUrl[0]->fileExists()) {
            Video::parseSource($id);
        }

        return $this->render('index', [
            'video' => $video,
            'id' => $id
        ]);
    }

    public function actionAdd()
    {
        $videoForm = new Video();
        $sourceForm = new Source();
        $uploadForm = new UploadForm();

        if (Yii::$app->request->isPost) {
            if ($videoForm->load(Yii::$app->request->post()) && $videoForm->validate()) {
                if ($sourceForm->load(Yii::$app->request->post()) && $sourceForm->validate()) {
                    $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');
                    $image = $uploadForm->upload();
                    $videoForm->image = $image;
                    $videoForm->save();
                    $sourceForm->vid = $videoForm->id;
                    $sourceForm->save();
                    return $this->render('add-confirm', []);
                }
            }
        }

        return $this->render('add', [
            'videoForm' => $videoForm,
            'sourceForm' => $sourceForm,
            'uploadForm' => $uploadForm
        ]);
    }

}
