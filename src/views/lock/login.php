<?php

use vasadibt\materialdashboard\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap\ActiveForm $form */
/** @var yii\base\Model $model */

$this->title = Yii::t('materialdashboard', 'Locked account');

$js = <<<JS
setTimeout(function() {
    $('.card').removeClass('card-hidden');
}, 700);
JS;
$this->registerJs($js);

$bundle = Yii::$app->assetManager->getBundle(\vasadibt\materialdashboard\assets\MaterialAsset::class);

?>
<div class="page-header lock-page header-filter" style="background-image: url('<?= $bundle->baseUrl . '/img/lock.jpg' ?>')">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                <div class="card card-profile card-hidden">
                    <div class="card-header">
                        <div class="card-avatar">
                            <img class="img" src="<?= $bundle->baseUrl . '/img/faces/marc.jpg' ?>" alt="avatar"/>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $model->user->username ?></h4>
                        <?php $form = ActiveForm::begin([]) ?>
                        <?= $form->errorSummary($model) ?>
                        <?= $form->field($model, 'password')
                            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
                            ->prepend(['content' => '<i class="material-icons">lock</i>'])
                            ->label(false) ?>

                        <div class="mt-4 text-center">
                            <?= Yii::$app->material->helperHtml::a(Yii::t('materialdashboard', 'Change account'), Yii::$app->user->loginUrl, ['class' => 'btn btn-info btn-round']) ?>
                            <?= Yii::$app->material->helperHtml::submitButton(Yii::t('materialdashboard', 'Login'), ['class' => 'btn btn-primary btn-round']) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('../layouts/_footer') ?>
</div>


