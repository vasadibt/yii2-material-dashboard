<?php

use vasadibt\materialdashboard\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap\ActiveForm $form */
/** @var yii\base\Model $loginForm */
/** @var yii\base\Model $passwordResetRequestForm */

$this->title = Yii::$app->name . ' - ' . Yii::t('materialdashboard', 'Sign in');

$js = <<<JS
setTimeout(function() {
    $('.card').removeClass('card-hidden');
}, 700);

$('.forgot-pass-btn').click(function (){
    $('#login-form').slideUp(300);
    $('#forgot-password-form').slideDown(300);
});

$('.back-to-login').click(function () {
    $("#login-form").slideDown(300);
    $("#forgot-password-form").slideUp(300);
});

JS;
$this->registerJs($js);


$bundle = Yii::$app->assetManager->getBundle(\vasadibt\materialdashboard\assets\MaterialAsset::class);

?>
<div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?= $bundle->baseUrl ?>/img/login.jpg'); background-size: cover; background-position: top center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                <div class="card card-login card-hidden">
                    <div class="card-header card-header-info text-center">
                        <h4 class="card-title"><?= Yii::$app->material->helperHtml::encode($this->title) ?></h4>
                    </div>
                    <div class="card-body">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
                        <?= $form->errorSummary($loginForm)?>

                        <?= $form->field($loginForm, 'email')
                            ->textInput(['placeholder' => $loginForm->getAttributeLabel('email'), 'autofocus' => 1])
                            ->prepend(['content' => '<i class="material-icons">email</i>'])
                            ->label(false) ?>

                        <?= $form->field($loginForm, 'password')
                            ->passwordInput(['placeholder' => $loginForm->getAttributeLabel('password')])
                            ->prepend(['content' => '<i class="material-icons">lock</i>'])
                            ->label(false) ?>

                        <div class="row justify-content-between m-0 mt-3 mb-3">
                            <?= Yii::$app->material->helperHtml::button(Yii::t('materialdashboard', 'Forgot your password?'), [
                                'class' => 'btn-link forgot-pass-btn',
                                'tabindex' => '-1',
                                'style' => 'border: none'
                            ]) ?>
                            <?= Yii::$app->material->helperHtml::submitButton(Yii::t('materialdashboard', 'Sign in'), ['class' => 'btn btn-info btn-sm btn-round']) ?>
                        </div>
                        <?php ActiveForm::end() ?>

                        <?php $form = ActiveForm::begin(['id' => 'forgot-password-form', 'options' => ['style' => 'display: none;']]) ?>
                        <?= $form->errorSummary($passwordResetRequestForm)?>
                        <?= $form->field($passwordResetRequestForm, 'email')
                            ->textInput(['placeholder' => $passwordResetRequestForm->getAttributeLabel('email'), 'autofocus' => 1])
                            ->prepend(['content' => '<i class="material-icons">email</i>'])
                            ->label(false) ?>
                        <div class="row justify-content-between m-0 mt-3 mb-3">
                            <?= Yii::$app->material->helperHtml::button(Yii::t('materialdashboard', 'Back to login'), ['class' => 'btn btn-warning btn-sm btn-round back-to-login']) ?>
                            <?= Yii::$app->material->helperHtml::submitButton(Yii::t('materialdashboard', 'Send email'), ['class' => 'btn btn-info btn-sm btn-round']) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->render('../layouts/_footer') ?>
</div>
