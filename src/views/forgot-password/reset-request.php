<?php

use vasadibt\materialdashboard\helpers\Html;
use vasadibt\materialdashboard\widgets\ActiveForm;
use vasadibt\materialdashboard\widgets\buttons\Link;
use vasadibt\materialdashboard\widgets\buttons\Submit;
use vasadibt\materialdashboard\widgets\Card;

/** @var yii\web\View $this */
/** @var \yii\base\Model $model */

$this->title = Yii::t('materialdashboard', 'Reset password');

$js = <<<JS
setTimeout(function() {
    $('.card').removeClass('card-hidden');
}, 700);
JS;
$this->registerJs($js);

$bundle = Yii::$app->assetManager->getBundle(\vasadibt\materialdashboard\assets\MaterialAsset::class);

?>
<div class="page-header lock-page header-filter" style="background-image: url('<?= $bundle->baseUrl ?>/img/lock.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">

                <?php Card::begin([
                    'containerOptions' => ['class' => ['type' => 'card-login', 'visibility' => 'card-hidden']],
                    'headerOptions' => ['class' => ['type' => 'card-header-info', 'text' => 'text-center']],
                    'title' => $this->title,
                    'footer' => [
                        Link::widget(['title' => Yii::t('materialdashboard', 'Back to login'), 'url' => ['/auth/user/login']]),
                        Submit::widget(['icon' => 'send', 'title' => Yii::t('materialdashboard', 'Send email'), 'form' => 'forgot-password-form']),
                    ],
                ]) ?>
                <?php $form = ActiveForm::begin(['id' => 'forgot-password-form']) ?>
                <?= $form->errorSummary($model) ?>
                <?= $form->field($model, 'email', ['addon' => ['prepend' => ['content' => Html::icon('email')]]])
                    ->textInput(['placeholder' => $model->getAttributeLabel('email')])
                    ->label(false) ?>
                <?php ActiveForm::end() ?>
                <?php Card::end() ?>
            </div>
        </div>
    </div>
</div>


