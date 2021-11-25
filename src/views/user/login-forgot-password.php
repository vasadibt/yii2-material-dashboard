<?php

use vasadibt\materialdashboard\helpers\Html;
use vasadibt\materialdashboard\widgets\ActiveForm;
use vasadibt\materialdashboard\widgets\buttons\Button;
use vasadibt\materialdashboard\widgets\buttons\Link;
use vasadibt\materialdashboard\widgets\buttons\Submit;
use vasadibt\materialdashboard\widgets\Card;

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
    
    $('#passwordresetrequest-email').val($('#login-email').val());
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

                <?php Card::begin([
                    'containerOptions' => ['class' => ['type' => 'card-login', 'visibility' => 'card-hidden']],
                    'headerOptions' => ['class' => ['type' => 'card-header-info', 'text' => 'text-center']],
                    'title' => $this->title,
                ]) ?>

                <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
                <?= $form->errorSummary($loginForm) ?>

                <?= $form->field($loginForm, 'email', ['addon' => ['prepend' => ['content' => Html::icon('email')]]])
                    ->textInput(['placeholder' => $loginForm->getAttributeLabel('email'), 'autofocus' => 1])
                    ->label(false) ?>

                <?= $form->field($loginForm, 'password', ['addon' => ['prepend' => ['content' => Html::icon('lock')]]])
                    ->passwordInput(['placeholder' => $loginForm->getAttributeLabel('password')])
                    ->label(false) ?>

                <div class="row justify-content-between m-0 mt-3 mb-3">
                    <?= Button::widget(['title' => Yii::t('materialdashboard', 'Forgot your password?'), 'options' => ['tabindex' => '-1', 'class' => ['id' => 'forgot-pass-btn'], 'type' => 'button'], 'optionType' => 'btn-link']) ?>
                    <?= Submit::widget(['icon' => 'login', 'title' => Yii::t('materialdashboard', 'Sign in')]) ?>
                </div>
                <?php ActiveForm::end() ?>

                <?php $form = ActiveForm::begin(['id' => 'forgot-password-form', 'options' => ['style' => 'display: none;']]) ?>
                <?= $form->errorSummary($passwordResetRequestForm) ?>
                <?= $form->field($passwordResetRequestForm, 'email', ['addon' => ['prepend' => ['content' => Html::icon('email')]]])
                    ->textInput(['placeholder' => $passwordResetRequestForm->getAttributeLabel('email')])
                    ->label(false) ?>

                <div class="row justify-content-between m-0 mt-3 mb-3">
                    <?= Button::widget(['title' => Yii::t('materialdashboard', 'Back to login'), 'options' => ['class' => ['id' => 'back-to-login'], 'type' => 'button']]) ?>
                    <?= Submit::widget(['icon' => 'send', 'title' => Yii::t('materialdashboard', 'Send email')]) ?>
                </div>
                <?php ActiveForm::end() ?>

                <?php Card::end() ?>

            </div>
        </div>
    </div>
    <?= $this->render('../layouts/_footer') ?>
</div>
