<?php

use vasadibt\materialdashboard\models\LoginForm;
use vasadibt\materialdashboard\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model LoginForm */

$this->title = Yii::t('materialdashboard', 'Sign In');

$js = <<<JS
setTimeout(function() {
    $('.card').removeClass('card-hidden');
}, 700);
JS;
$this->registerJs($js);


$bundle = Yii::$app->assetManager->getBundle(\vasadibt\materialdashboard\assets\MaterialAsset::class);

?>
<div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?= $bundle->baseUrl . '/img/login.jpg' ?>'); background-size: cover; background-position: top center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                <div class="card card-login card-hidden">
                    <div class="card-header card-header-info text-center">
                        <h4 class="card-title"><?= Yii::$app->material->helperHtml::encode($this->title) ?></h4>
                    </div>
                    <div class="card-body">
                        <?php $form = ActiveForm::begin([]) ?>
                        <?= $form->errorSummary($model)?>
                        <?= $form->field($model, 'email')
                            ->textInput(['placeholder' => $model->getAttributeLabel('email')])
                            ->prepend(['content' => '<i class="material-icons">email</i>'])
                            ->label(false) ?>
                        <?= $form->field($model, 'password')
                            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
                            ->prepend(['content' => '<i class="material-icons">lock</i>'])
                            ->label(false) ?>
                        <div class="mt-4 text-center">
                            <?= Yii::$app->material->helperHtml::submitButton(Yii::t('materialdashboard', 'Sign in'), ['class' => 'btn btn-info']) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->render('../layouts/_footer') ?>
</div>
