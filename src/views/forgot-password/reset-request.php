<?php

use vasadibt\materialdashboard\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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

                <?php $form = ActiveForm::begin([]) ?>

                <div class="card card-login card-hidden">
                    <div class="card-header card-header-info text-center">
                        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
                    </div>
                    <div class="card-body">
                        <?= $form->errorSummary($model)?>
                        <?= $form->field($model, 'email')
                            ->textInput(['placeholder' => $model->getAttributeLabel('email'), 'autofocus' => 1])
                            ->prepend(['content' => '<i class="material-icons">email</i>'])
                            ->label(false) ?>
                        </div>
                    <div class="card-footer">
                        <?= Html::a(Yii::t('materialdashboard', 'Back to login'), Yii::$app->user->loginUrl, ['class' => 'btn btn-warning btn-sm btn-round']) ?>
                        <?= Html::submitButton(Yii::t('materialdashboard', 'Send email'), ['class' => 'btn btn-info btn-sm btn-round']) ?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
