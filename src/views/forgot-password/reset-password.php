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

                <div class="card card-profile card-hidden">
                    <div class="card-header card-header-info text-center">
                        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $model->user->username ?></h4>

                        <?= $form->errorSummary($model)?>

                        <?= $form->field($model, 'newPassword')
                            ->passwordInput(['placeholder' => $model->getAttributeLabel('newPassword'), 'autofocus' => 1])
                            ->prepend(['content' => '<i class="material-icons">lock</i>'])
                            ->label(false) ?>

                        <?= $form->field($model, 'retypePassword')
                            ->passwordInput(['placeholder' => $model->getAttributeLabel('retypePassword')])
                            ->prepend(['content' => '<i class="material-icons">lock</i>'])
                            ->label(false) ?>

                    </div>
                    <div class="card-footer justify-content-center">
                        <?= Html::a(Yii::t('materialdashboard','Change account'), Yii::$app->user->loginUrl,['class' => 'btn btn-info btn-round']) ?>
                        <?= Html::submitButton(Yii::t('materialdashboard','Login'), ['class' => 'btn btn-primary btn-round']) ?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>


