<?php

/** @var yii\web\View $this */
/** @var \yii\db\ActiveRecordInterface $model */
/** @var string $form */

?>
<div class="row">
    <div class="col-xl-8 offset-xl-2">
        <div class="card">
            <div class="card-header card-header-icon">
                <div class="card-icon d-none d-sm-block"><?= Yii::$app->material->helperHtml::icon('assignment') ?></div>
                <h4 class="card-title d-inline-block"><?= Yii::$app->material->helperHtml::encode($this->title) ?></h4>
                <div class="float-right">
                    <?= Yii::$app->material->helperButton::delete($model) ?>
                    <?= Yii::$app->material->helperButton::back() ?>
                </div>
            </div>
            <div class="card-body">
                <?= $form ?>
            </div>
        </div>
    </div>
</div>
