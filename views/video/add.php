<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $videoForm \app\models\Video */
/* @var $uploadForm \app\models\UploadForm */
/* @var $sourceForm \app\models\Source */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление фильма';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($videoForm, 'title')->textInput(['autofocus' => true]) ?>

    <?= $form->field($videoForm, 'title_origin')->textInput() ?>

    <?= $form->field($uploadForm, 'imageFile')->fileInput() ?>

    <?= $form->field($sourceForm, 'type')->dropDownList(['ParserVk' => 'Вконтакте', 'ParserFilmix' => 'Filmix.net']) ?>

    <?= $form->field($sourceForm, 'url')->textInput()->label('Источник url') ?>

    <?= $form->field($videoForm, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>